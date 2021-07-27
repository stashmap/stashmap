<?php

namespace Controllers;

class Clan extends Base {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        if ($this->isLoggedIn) redirect('/map');

        $errors = [];
        $name = '';
        $password = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? null;
            $name = preg_replace('!\s+!', ' ', $name);
            $name = trim($name);
            $password = $_POST['password'] ?? null;
            $rememberMe = isset($_POST['rememberMe']);

            if (!$name) $errors[] = 'Clan name must not be empty';
            if (!$password) $errors[] = 'Password must not be empty';

            $clan = $this->em->createQueryBuilder()
                    ->select('c')
                    ->from('Models\Clan', 'c')
                    ->where("c.name = :name OR c.email = :name")
                    ->setParameter('name', $name)
                    ->getQuery()
                    ->setMaxResults(1)
                    ->getOneOrNullResult();
            ;

            if ($clan && password_verify($password, $clan->master_password)) {
                $data = ['emailConfirmation' => $clan->email_confirmation];
                $this->logAction(\Components\Config::get('actionTypes')['Logging as clan leader'], $clan->id, $data);
                
                if (!$clan->email_confirmation) {
                    $_SESSION['email'] = $clan->email;
                    redirect('/email/confirmation/request-check-mail');
                }
                $_SESSION['clanId'] = $clan->id;
                $_SESSION['isMaster'] = true;
                $_SESSION['isUser'] = true;
                $_SESSION['masterPasswordFingerprint'] = $clan->master_password_fingerprint;

                if ($rememberMe) {
                    setcookie('clanName', $clan->name, time() + 60 * 60 * 24 * 365, '/');
                    setcookie('password', $clan->master_password, time() + 60 * 60 * 24 * 365, '/');
                }
                redirect('/map');
            } elseif ($clan && password_verify($password, $clan->password)) {
                $data = ['emailConfirmation' => $clan->email_confirmation];
                $this->logAction(\Components\Config::get('actionTypes')['Logging as member'], $clan->id, $data);

                if (!$clan->email_confirmation) {
                    $_SESSION['email'] = $clan->email;
                    redirect('/email/confirmation/request-check-mail');
                }
                $_SESSION['clanId'] = $clan->id;
                $_SESSION['isMaster'] = false;
                $_SESSION['isUser'] = true;
                $_SESSION['passwordFingerprint'] = $clan->password_fingerprint;

                if ($rememberMe) {
                    setcookie('clanName', $clan->name, time() + 60 * 60 * 24 * 365, '/');
                    setcookie('password', $clan->password, time() + 60 * 60 * 24 * 365, '/');
                }
                redirect('/map');
            } else {
                $errors[] = 'Sorry. Username or password is incorrect';
                
                $data = [
                    'errors' => $errors, 
                    'name' => $name, 
                    'password' => $password, 
                ];
                $this->logAction(\Components\Config::get('actionTypes')['Invalid logging'], 0, $data);
            }
        }

        $this->logAction(\Components\Config::get('actionTypes')['Visit home page'], 0);

        $this->view('login', [
            'errors' => $errors,
            'name' => $name,
            'password' => $password,
        ]);
    }

    public function logout() {
        $this->logAction(\Components\Config::get('actionTypes')['Logout'], $this->clan->id, []);
        session_unset();
        setcookie('clanName', '', '/');
        setcookie('password', '', '/');
        redirect('/');
    }

    public function page404() {
        $this->view('page404');
    }

    public function registration() {
        if ($this->isLoggedIn) redirect('/map');

        $errors = [];
        $name = '';
        $email = '';
        $userPassword = '';
        $password = '';
        $passwordConfirm = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? null;
            $name = preg_replace('!\s+!', ' ', $name);
            $name = trim($name);
            $email = $_POST['email'] ?? null;
            $userPassword = $_POST['userPassword'] ?? null;
            $password = $_POST['password'] ?? null;
            $passwordConfirm = $_POST['passwordConfirm'] ?? null;

            

            $regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i"; 
            if (!$name) $errors[] = 'Clan name field must not be empty';
            if (!preg_match($regex, $email)) $errors[] = 'Invalid email';
            if (!$email) $errors[] = 'Email field must not be empty';
            if (!$userPassword) $errors[] = 'Member password field must not be empty';
            if (!$password) $errors[] = 'Clan leader password field must not be empty';
            if (!$passwordConfirm) $errors[] = 'Clan leader password confirmation field must not be empty';

            $clan = $this->em->createQueryBuilder()
                    ->select('c')
                    ->from('Models\Clan', 'c')
                    ->where("c.name = :name")
                    ->setParameter('name', $name)
                    ->getQuery()
                    ->setMaxResults(1)
                    ->getOneOrNullResult();
            ;

            if ($clan && !$clan->email_confirmation) {
                $clan->delete();
                $clan = null;
            }

            if ($clan) $errors[] = 'Clan already exists';
            
            if ($password !== $passwordConfirm) $errors[] = 'Clan leader password and master password confirmation do not match';


            $clan = $this->em->createQueryBuilder()
                    ->select('c')
                    ->from('Models\Clan', 'c')
                    ->where("c.email = :email")
                    ->setParameter('email', $email)
                    ->getQuery()
                    ->setMaxResults(1)
                    ->getOneOrNullResult();
            ;

            if ($clan) $errors[] = 'An account has already been registered for this email';

            $options = [
                'cost' => \Components\Config::get('password_cost')
            ];

            if (!$errors) {
                $clan = new \Models\Clan();
                $clan->name = $name;
                $clan->email = $email;
                $clan->master_password = password_hash($password, PASSWORD_BCRYPT, $options);
                $now = new \DateTime();
                $clan->master_password_fingerprint = md5(random_bytes(random_int(10,100)).$now->format('d-m-Y H:i:s'));
                $clan->password = password_hash($userPassword, PASSWORD_BCRYPT, $options);
                $clan->password_fingerprint = md5(random_bytes(random_int(10,100)).$now->format('d-m-Y H:i:s'));
                $clan->tier = 0;
                $clan->save();
                $token = $this->newEmailConfirmationTokenAssignToClan($clan);

                $map = new \Models\Map();
                $map->clan_id = $clan->id;
                $map->name = \Components\Config::get('test_first_map_name');
                $map->map_filename = \Components\Config::get('test_first_map_filename');
                $map->enabled = 1; 
                $map->save();

                $clan->current_map_id = $map->id;
                $clan->save();

                $_SESSION['email'] = $email;
                        
                $this->sendConfirmationEmail($email, $token);
                $data = [
                    'email' => $email,
                    'token' => $token,
                    'clanId' => $clan->id,
                    'clanName' => $name,
                ];
                $this->logAction(\Components\Config::get('actionTypes')['Successful registration. Email confirmative token sended'], $clan->id, $data);
                redirect('/email/confirmation/request-check-mail');
            } else {
                $data = [
                    'name' => $name,
                    'password' => $password,
                    'email' => $email,
                    'errors' => $errors
                ];
                $this->logAction(\Components\Config::get('actionTypes')['Registration failed'], 0, $data);
            }
        }
        
        $this->logAction(\Components\Config::get('actionTypes')['Visit register page'], 0, []);

        $this->view('registration', [
            'errors' => $errors,
            'name' => $name,
            'email' => $email,
            'userPassword' => $userPassword,
            'password' => $password,
            'passwordConfirm' => $passwordConfirm,
        ]);
    }

    private function newEmailConfirmationTokenAssignToClan($clan) {
        $now = new \DateTime();
        $token = md5(random_bytes(random_int(10,100)).$now->format('d-m-Y H:i:s'));
        $clan->email_confirmation_token = $token;
        $clan->save();
        return $token;
    }

    private function sendConfirmationEmail($email, $token) {
        $now = new \DateTime();

        ob_start();
        $this->view('email-confirmation/email', ['token'=>$token, 'email'=>$email]);
        $message = ob_get_contents();
        ob_end_clean();

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <noreplay@stashmap.net>' . "\r\n";

        $emailSended = mail($email,"Stashmap. Account confirmation", $message, $headers);
    }

    public function emailConfirmationRequestCheckMail() {
        if ($this->isLoggedIn) redirect('/map');
        if (!isset($_SESSION['email'])) redirect('/');
        
        $email = $_SESSION['email'];
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'] ?? null;

            if (!$token) $errors[] = 'Token must not be empty';

            $clan = $this->em->createQueryBuilder()
                ->select('c')
                ->from('Models\Clan', 'c')
                ->where("c.email = :email AND c.email_confirmation_token = :token ")
                ->setParameters(['email' => $email, 'token' => $token])
                ->getQuery()
                ->setMaxResults(1)
                ->getOneOrNullResult();
            ;

            if ($clan) {
                $clan->email_confirmation = true;
                $clan->save();
                
                $this->logAction(\Components\Config::get('actionTypes')['Email confirmation token correct'], $clan->id, []);

                redirect('/email/confirmation/success');
            } else {
                $errors[] = 'Incorrect token';
                $data = [
                    'errors' => $errors,
                    'token' => $token
                ];
                $this->logAction(\Components\Config::get('actionTypes')['Email confirmation token incorrect'], 0, $data);
            }

        }
        $this->logAction(\Components\Config::get('actionTypes')['Visit email confirmation page'], 0, []);

        $this->view('email-confirmation/check-email', [
            'errors' => $errors,
            'email' => $email,
            'resendTime' => $_SESSION['resendTime'] ?? null, 
        ]);
    }

    public function emailConfirmationSuccess() {
        $this->view('email-confirmation/success', [
        ]);
    }

    public function resendConfirmationEmail() {
        if ($this->isLoggedIn) redirect('/map');
        if (!isset($_SESSION['email'])) redirect('/');

        $email = $_SESSION['email'];
        $_SESSION['emailResend'] = true;
        $_SESSION['resendTime'] = new \DateTime();

        $clan = $this->em->createQueryBuilder()
            ->select('c')
            ->from('Models\Clan', 'c')
            ->where("c.email = :email")
            ->setParameter('email', $email)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
        ;

        $token = $this->newEmailConfirmationTokenAssignToClan($clan);
        $this->sendConfirmationEmail($email, $token);
        redirect('/email/confirmation/request-check-mail');
    }

    public function mapCreation() {
        if (!$this->isLoggedIn) redirect ('/');
        if (!$this->isMaster) redirect('/');
        if (!(\Components\Config::get('tierMapCount')[$this->clan->tier] > count($this->clan->maps))) redirect('/');
        
        if (empty($_COOKIE['colPicWidth'])) {
            setcookie("colPicWidth", \Components\Config::get('pic_column_image_width_default'), time() + 1000 * 60 * 60 * 24 * 365, '/');
        }

        $usi = \Components\Storage::get('usi');
        $this->logAction(\Components\Config::get('actionTypes')['Visit map creation by in-game map page'], $this->clan->id, []);
        $pics = [];
        if ($usi) {
            $pics = $this->getMapParts();
        } else {
            $this->view('map/creation', ['pics' => []]);
            return;
        }

        if (count($pics) < 2) {
            $this->view('map/creation', ['pics' => []]);
            return;
        }

        $imageSize = getimagesize(\Components\Config::get('folders')['pic_uploads'].'/'.$pics[1]->url);

        $pics[1]->width = $imageSize[0];
        $pics[1]->height = $imageSize[1];
        $pics[1]->top = 0;
        $pics[1]->left = 0;

        $imageSize = getimagesize(\Components\Config::get('folders')['pic_uploads'].'/'.$pics[0]->url);

        $pics[0]->width = $imageSize[0];
        $pics[0]->height = $imageSize[1];
        $pics[0]->top = $pics[0]->width - $pics[0]->height;
        $pics[0]->left = 0;


        $this->view('map/creation', ['pics' => $pics, 'mapPartsHash' => $this->getMapPartsHash($pics)]);
    }

    public function mapCreateImage() {
        if (!$this->isLoggedIn || !$this->isMaster ) {
            echo "ERROR";
            return;
        }

        if (!(\Components\Config::get('tierMapCount')[$this->clan->tier] > count($this->clan->maps))) {
            echo "ERROR";
            return;
        }

        $name = $_POST['name'] ?? null;
        $defaultMap = $_POST['defaultMap'] ?? null;

        $mapPartsTop_Top = $_POST['mapPartsTop_Top'] ?? null;
        $mapPartsTop_Left = $_POST['mapPartsTop_Left'] ?? null;
        $mapPartsBottom_Top = $_POST['mapPartsBottom_Top'] ?? null;
        $mapPartsBottom_Left = $_POST['mapPartsBottom_Left'] ?? null;
        $boundsTopLeft_Top = $_POST['boundsTopLeft_Top'] ?? null;
        $boundsTopLeft_Left = $_POST['boundsTopLeft_Left'] ?? null;
        $boundsBottomRight_Top = $_POST['boundsBottomRight_Top'] ?? null;
        $boundsBottomRight_Left = $_POST['boundsBottomRight_Left'] ?? null;

        if (
            $mapPartsTop_Top === null ||
            $mapPartsTop_Left === null ||
            $mapPartsBottom_Top === null ||
            $mapPartsBottom_Left === null  ||
            $boundsTopLeft_Top === null ||
            $boundsTopLeft_Left === null ||
            $boundsBottomRight_Top === null ||
            $boundsBottomRight_Left === null 
        ) {
            echo "ERROR";
            return;
        }

        if ($boundsTopLeft_Left > $boundsBottomRight_Left || $boundsTopLeft_Top > $boundsBottomRight_Top) {
            echo "ERROR";
            return;
        }


        // Transfer closer to zero
        $minOffsetTop = $boundsBottomRight_Top;
        $minOffsetLeft = $boundsBottomRight_Left;
        $minOffsetTop = $minOffsetTop > $mapPartsTop_Top ? $mapPartsTop_Top : $minOffsetTop;
        $minOffsetTop = $minOffsetTop > $mapPartsBottom_Top ? $mapPartsBottom_Top : $minOffsetTop;
        $minOffsetTop = $minOffsetTop > $boundsTopLeft_Top ? $boundsTopLeft_Top : $minOffsetTop;
        $minOffsetTop = $minOffsetTop > $boundsBottomRight_Top ? $boundsBottomRight_Top : $minOffsetTop;

        $minOffsetLeft = $minOffsetLeft > $mapPartsTop_Left ? $mapPartsTop_Left : $minOffsetLeft;
        $minOffsetLeft = $minOffsetLeft > $mapPartsBottom_Left ? $mapPartsBottom_Left : $minOffsetLeft;
        $minOffsetLeft = $minOffsetLeft > $boundsTopLeft_Left ? $boundsTopLeft_Left : $minOffsetLeft;
        $minOffsetLeft = $minOffsetLeft > $boundsBottomRight_Left ? $boundsBottomRight_Left : $minOffsetLeft;

        $mapPartsTop_Top = $mapPartsTop_Top - $minOffsetTop;
        $mapPartsBottom_Top = $mapPartsBottom_Top - $minOffsetTop;
        $boundsTopLeft_Top = $boundsTopLeft_Top - $minOffsetTop;
        $boundsBottomRight_Top = $boundsBottomRight_Top - $minOffsetTop;

        $mapPartsTop_Left = $mapPartsTop_Left - $minOffsetLeft;
        $mapPartsBottom_Left = $mapPartsBottom_Left - $minOffsetLeft;
        $boundsTopLeft_Left = $boundsTopLeft_Left - $minOffsetLeft;
        $boundsBottomRight_Left = $boundsBottomRight_Left - $minOffsetLeft;

        // getting size of map-parts-images
        $usi = \Components\Storage::get('usi');
        $pics = [];
        if ($usi) {
            $pics = $this->getMapParts();
        } else {
            echo "Sorry, create map can be done only with app";
            return;
        }


        $mapPartsTopUrl = \Components\Config::get('folders')['pic_uploads'].'/'.$pics[1]->url;
        $imageSize = getimagesize($mapPartsTopUrl);
        $mapPartsTopWidth = $imageSize[0];
        $mapPartsTopHeight = $imageSize[1];


        $mapPartsBottomUrl = \Components\Config::get('folders')['pic_uploads'].'/'.$pics[0]->url;
        $imageSize = getimagesize($mapPartsBottomUrl);
        $mapPartsBottomWidth = $imageSize[0];
        $mapPartsBottomHeight = $imageSize[1];

        // figuring out canvas size
        $canvasWidth = $mapPartsTop_Left + $mapPartsTopWidth;
        $canvasWidth = $canvasWidth < ($mapPartsBottom_Left + $mapPartsBottomWidth) ? $mapPartsBottom_Left + $mapPartsBottomWidth : $canvasWidth;
        $canvasWidth = $canvasWidth < $boundsBottomRight_Left ? $boundsBottomRight_Left : $canvasWidth;

        $canvasHeight = $mapPartsTop_Top + $mapPartsTopHeight;
        $canvasHeight = $canvasHeight < ($mapPartsBottom_Top + $mapPartsBottomHeight) ? $mapPartsBottom_Top + $mapPartsBottomHeight : $canvasHeight;
        $canvasHeight = $canvasHeight < $boundsBottomRight_Top ? $boundsBottomRight_Top : $canvasHeight;

        $maxImageSize = 5000;

        if ($canvasHeight > $maxImageSize || $canvasWidth > $maxImageSize) {
            sleep($canvasWidth*$canvasHeight/2500000);
            $data = [
                'error' => 'ERROR_TOO_BIG_IMAGE',
                'canvasWidth' => $canvasWidth,
                'canvasHeight' => $canvasHeight,
            ];
            $this->logAction(\Components\Config::get('actionTypes')['Map creating by in-game map'], $this->clan->id, $data);
            echo "ERROR_TOO_BIG_IMAGE";
            return;
        }

        //creating image
        $im = imagecreatetruecolor($canvasWidth, $canvasHeight);

        if( preg_match( "/[#]?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})/i", \Components\Config::get('map_creating_background_color'), $matches ) )
        {
            $red = hexdec( $matches[1] );
            $green = hexdec( $matches[2] );
            $blue = hexdec( $matches[3] );
        }
        $background = imagecolorallocate($im, $red, $green, $blue);
        imagefill($im, 0, 0, $background);


        $src = imagecreatefrompng(ROOT . '/' . $mapPartsTopUrl);

        imagecopymerge($im, $src, $mapPartsTop_Left, $mapPartsTop_Top, 0, 0, $mapPartsTopWidth, $mapPartsTopHeight, 100);
        $src = imagecreatefrompng(ROOT . '/' . $mapPartsBottomUrl);
        imagecopymerge($im, $src, $mapPartsBottom_Left, $mapPartsBottom_Top, 0, 0, $mapPartsBottomWidth, $mapPartsBottomHeight, 100);
        $imCropped = imagecrop($im, ['x' => $boundsTopLeft_Left, 'y' => $boundsTopLeft_Top, 'width' => $boundsBottomRight_Left - $boundsTopLeft_Left, 'height' => $boundsBottomRight_Top - $boundsTopLeft_Top]);
        
        $now = new \DateTime();
        $fileName = $now->format("d.m.Y_H-i-s") . '_' . bin2hex(random_bytes(5)). '.png';

        imagepng($imCropped, ROOT . '/' . \Components\Config::get('folders')['maps'] . '/' . $fileName);

        //Creating new map for image
        $map = new \Models\Map();
        $map->clan = $this->clan;
        $map->name = $name;
        $map->map_filename = $fileName;
        $map->save();

        if ($defaultMap) $this->clan->current_map_id = $map->id;
        $this->clan->save();
    
        $data = [
            'fileName' => $fileName,
            'defaultMap' => $defaultMap,
        ];
        $this->logAction(\Components\Config::get('actionTypes')['Map creating by in-game map'], $map->id, $data);
        echo "OK";
        
    }

    public function getMapParts() {
        $usi = \Components\Storage::get('usi');
        $pics = $this->em->createQueryBuilder()
            ->select('p')
            ->from('Models\Pic', 'p')
            ->where("p.usi = :usi AND p.enabled = 1 AND p.type = :pic_type_as_map_part")
            ->orderBy('p.id', 'DESC')
            ->setParameters(['usi' => $usi, 'pic_type_as_map_part' => \Components\Config::get('picTypes')['mapPart']])
            ->getQuery()
            ->setMaxResults(2)
            ->getResult()
        ;

        return $pics;
    }

    public function getMapPartsHashAsString() {
        echo $this->getMapPartsHash();
        return;
    }

    public function getMapPartsHash($pics = null) {
        $pics = $pics ? $pics : $this->getMapParts();
        $data = '';
        foreach($pics as $pic) {
            $data .= $pic->url;
        }
        return hash('md5', $data);
    }

    public function settings() {
        if (!$this->isMaster) redirect ('/');
        $successMessages = [];
        $errors = [];
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') === 0) {


            $name = $_POST['name'] ?? null;
            if ($name) {
                $clan = $this->em->createQueryBuilder()
                        ->select('c')
                        ->from('Models\Clan', 'c')
                        ->where("c.name = :name")
                        ->setParameter('name', $name)
                        ->getQuery()
                        ->setMaxResults(1)
                        ->getOneOrNullResult();
                ;

                if ($clan) {
                    $errors[] = 'Clan already exists';
                    $data = [
                        'oldName' => $this->clan->name,
                        'newName' => $name,
                        'errors' => $errors,
                    ];
                    $this->logAction(\Components\Config::get('actionTypes')['Changing clan name error'], $this->clan->id, $data);
                } else {
                    $data = [
                        'oldName' => $this->clan->name,
                        'newName' => $name,
                    ];
                    $this->logAction(\Components\Config::get('actionTypes')['Changing clan name'], $this->clan->id, $data);
                    $this->clan->name = $name;
                    $this->clan->save();
                    $successMessages[] = 'Clan name changed successfully';
                }
                
            }


            $userPassword = $_POST['userPassword'] ?? null;
            $userPasswordConfirmation = $_POST['userPasswordConfirmation'] ?? null;
            $masterPasswordUser = $_POST['masterPasswordUser'] ?? null;
            if ($userPassword || $userPasswordConfirmation) {
                if ($userPassword === $userPasswordConfirmation) {
                    if (password_verify($masterPasswordUser, $this->clan->master_password)) {
                        $options = [
                            'cost' => \Components\Config::get('password_cost')
                        ];
                        $now = new \DateTime();
                        $this->clan->password = password_hash($userPassword, PASSWORD_BCRYPT, $options);
                        $this->clan->password_fingerprint = $_SESSION['passwordFingerprint'] = md5(random_bytes(random_int(10,100)).$now->format('d-m-Y H:i:s'));
                        $this->clan->save();
                        $successMessages[] = 'Member password changed successfully';
                        $this->logAction(\Components\Config::get('actionTypes')['Changing member password'], $this->clan->id, []);
                    } else {
                        $errors[] = 'Incorrect clan leader password specified';
                    }
                } else {
                    $errors[] = 'Member password and Member password confirmation do not match';
                }
            }

            $newMasterPassword = $_POST['newMasterPassword'] ?? null;
            $newMasterPasswordConfirmation = $_POST['newMasterPasswordConfirmation'] ?? null;
            $masterPasswordMaster = $_POST['masterPasswordMaster'] ?? null;
            if ($newMasterPassword || $newMasterPasswordConfirmation) {
                if ($newMasterPassword === $newMasterPasswordConfirmation) {
                    if (password_verify($masterPasswordMaster, $this->clan->master_password)) {
                        $options = [
                            'cost' => \Components\Config::get('password_cost')
                        ];
                        $now = new \DateTime();
                        $this->clan->master_password = password_hash($newMasterPassword, PASSWORD_BCRYPT, $options);
                        $this->clan->master_password_fingerprint = $_SESSION['masterPasswordFingerprint'] = md5(random_bytes(random_int(10,100)).$now->format('d-m-Y H:i:s'));
                        $this->clan->save();
                        $successMessages[] = 'Clan leader password changed successfully';
                        $this->logAction(\Components\Config::get('actionTypes')['Changing clan leader password'], $this->clan->id, []);
                    } else {
                        $errors[] = 'Incorrect clan leader password specified '.$masterPassword;
                    }
                } else {
                    $errors[] = 'New clan leader password and new clan leader password confirmation do not match';
                }
            }


     
        };

        $this->logAction(\Components\Config::get('actionTypes')['Visit clan-settings page'], $this->clan->id, []);
        
        $this->view('clan-settings',[
            'clanName' => $this->clan->name,
            'successMessages' => $successMessages,
            'errors' => $errors,
        ]);
    }

    public function maps() {
        if (!$this->isMaster) redirect ('/');
        $this->logAction(\Components\Config::get('actionTypes')['Visit map management page'], $this->clan->id, []);

        $this->view('map/maps',[
            'maps' => $this->clan->maps,
            'canCreateMaps' => \Components\Config::get('tierMapCount')[$this->clan->tier] > count($this->clan->maps) ? true : false,
        ]);

    }
    
    public function deleteMap() {
        if (!$this->isMaster) return;
        if (!$this->isLoggedIn) return;        
        
        $mapId = $_POST['mapId'] ?? null;

        $map = $this->clan->getMapOfClanById($mapId); 
        if (!$map) return;

        $this->logAction(\Components\Config::get('actionTypes')['Delete map'], $map->id, []);

        foreach($map->markers as $marker) {
            foreach($marker->pics as $pic) {
                $pic->deleteFiles();
                $pic->delete(false);
            }
            $marker->delete(false);
        }

        if (!unlink(\Components\Config::get('folders')['maps'] . '/' . $map->map_filename)) {
            l($map->id." map ".$map->map_filename."deletion caused an error");
        }
        
        $map->delete(false);
        $this->em->flush();
        
        if ((int)$mapId === $this->clan->current_map_id) {
            $maps = $this->clan->maps; 
            if (count($maps)>=1) {
                $map = $maps[count($maps)-1];
                $this->clan->current_map_id = $map->id;
                $this->clan->save();
            }
        }

        $data = [
            'status' => 'OK'
        ];
        echo json_encode($data);
    }




    public function renameMap() {
        if (!$this->isMaster) return;
        if (!$this->isLoggedIn) return;        
        $mapId = $_POST['mapId'] ?? null;
        $newMapName = $_POST['newMapName'] ?? null;
        
        $map = $this->clan->getMapOfClanById($mapId); 
        if (!$map) return;
        $map->name = $newMapName;
        $map->save();
        
        $data = [
            'status' => 'OK'
        ];
        echo json_encode($data);
    }

    public function makeDefaultMap() {
        if (!$this->isMaster) return;
        if (!$this->isLoggedIn) return;        
        
        $mapId = $_POST['mapId'] ?? null;
        
        $map = $this->clan->getMapOfClanById($mapId); 
        if (!$map) return;

        $this->clan->current_map_id = $mapId;
        $this->clan->save();

        $data = [
            'status' => 'OK'
        ];
        echo json_encode($data);
    }


    public function mapCreationByUploadedFile() {
        if (!$this->isMaster) redirect('/map');
        if (!(\Components\Config::get('tierMapCount')[$this->clan->tier] > count($this->clan->maps))) redirect('/map');
        $errors = [];
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') === 0) {

            $ip = $_SERVER["REMOTE_ADDR"];
            $now = new \DateTime();
            $datetimestamp = $now->sub(new \DateInterval('PT'.\Components\Config::get('upload')['map']['period_in_minutes'].'M'));

            $maps = $this->em->createQueryBuilder()
                ->select('m.id')
                ->from('Models\Map', 'm')
                ->where("m.ip = :ip AND m.created > :dat ")
                ->setParameters(['ip' => $ip, 'dat' => $datetimestamp])
                ->getQuery()
                ->getResult();
            ;

            if (count($maps) >= \Components\Config::get('upload')['map']['allowed_quantity_at_period']) {
                $errors[] = 'Too many maps loaded. Try later';
                goto loadForm;
            }

            if (empty($_FILES["fileToUpload"]['name'])) {
                $errors[] = 'No image selected for upload';
                goto loadForm;
            } 

            $fileName = bin2hex(random_bytes(5)) . '_'. basename($_FILES["fileToUpload"]["name"]);
            $targetFile = \Components\Config::get('folders')['maps'].'/'.$fileName;
            
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check === false) {
                $errors[] = 'The file you uploaded is not an image';
                goto loadForm;
            }

            // Check if file already exists
            if (file_exists($targetFile)) {
                $errors[] = 'Unknown error. Please, try again';
                goto loadForm;
            }

            $allowedSize = \Components\Config::get('upload')['map']['map_max_file_size'];
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > $allowedSize) {
                $errors[] = 'Image is too large';
                goto loadForm;
            }
            
            // Allow certain file formats
            $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $errors[] = 'Only .png and .jpg images are supported';
                goto loadForm;
            }

            if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                $errors[] = 'Unknown error. Please, try again';
                goto loadForm;
            }
            
            $map = new \Models\Map();
            $map->name = $_POST['name'];
            $map->map_filename = $fileName;
            $map->clan = $this->clan;
            $map->ip = $ip;
            $map->enabled = 1;
            $map->save();

            $makeNewMapByDefault = $_POST['defaultMap'] ?? null;

            if ($makeNewMapByDefault) {
                $this->clan->current_map_id = $map->id;
                $this->clan->save();
            }

            $data = [
                'fileName' => $fileName,
                'defaultMap' => $defaultMap,
            ];
            $this->logAction(\Components\Config::get('actionTypes')['Map creating by image'], $map->id, $data);
            redirect('/map');

        };

        loadForm:

        if ($errors) {
            $data = [
                'errors' => $errors,
            ];
        } else {
            $data = [];
        }
        $this->logAction(\Components\Config::get('actionTypes')['Map creating by image'], $this->clan->id, $data);

        $this->view('map/creation-file',[
            'errors' => $errors
        ]);
    }

    public function passwordForgot() {
        $errors = [];
        $email = '';
        $emailSended = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? null;

            if (!$email) {
                $errors[] = 'Email field must not be empty';
                goto loadPage;
            }

            $clan = $this->em->createQueryBuilder()
                ->select('c')
                ->from('Models\Clan', 'c')
                ->where("c.email = :email")
                ->setParameter('email', $email)
                ->getQuery()
                ->setMaxResults(1)
                ->getOneOrNullResult();
            ;

            if (!$clan) {
                $errors[] = "Email not found";
                goto loadPage;
            }

            $now = new \DateTime();
            
            if (false && $clan->cooldown instanceof \DateTime && $now < $clan->cooldown) {
                $errors[] = "Password reset no more than 1 time in 15 minutes";
                goto loadPage;
            } 

            $cooldownDate = clone $now;
            $cooldownDate->add( new \DateInterval('PT'.\Components\Config::get('email_password_reset_cooldown_minutes').'M')); 
            $clan->cooldown = $cooldownDate;
            $clan->save();

            if (!$errors) {
                $now = new \DateTime();
                $token = md5(random_bytes(random_int(10,100)).$now->format('d-m-Y H:i:s'));
                $clan->token = $token;
                $clan->save();

                ob_start();
                $this->view('password-reset-email', ['token'=>$token, 'email'=>$email]);
                $message = ob_get_contents();
                ob_end_clean();

                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // More headers
                $headers .= 'From: <noreplay@stashmap.net>' . "\r\n";

                // send email
                // $emailSended = mail("heyimbi@protonmail.com","Reset password",$message, $headers);
                $emailSended = mail($clan->email,"Stashmap.net. Reset password",$message, $headers);
                // mail.ukraine.com.ua.
            }
        }

        loadPage:
        $this->view('forgot-password', [
            'errors' => $errors,
            'email' => $email,
            'emailSended' => $emailSended,
        ]);
    }

    public function passwordReset($token, $email) {
        $errors = [];
        $passwordChanged = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? null;
            $passwordConfirmation = $_POST['passwordConfirmation'] ?? null;

            if (!$password) {
                $errors[] = 'Password field must not be empty';
                goto loadPage;
            }
            
            if (!$passwordConfirmation) {
                $errors[] = 'Password confirmation field must not be empty';
                goto loadPage;
            }
            
            if ($password !== $passwordConfirmation) {
                $errors[] = 'Master password and master password confirmation do not match';            
                goto loadPage;
            }

            $clan = $this->em->createQueryBuilder()
                ->select('c')
                ->from('Models\Clan', 'c')
                ->where("c.email = :email AND c.token = :token ")
                ->setParameters(['email' => $email, 'token' => $token])
                ->getQuery()
                ->setMaxResults(1)
                ->getOneOrNullResult();
            ;

            if (!$clan) {
                $errors[] = 'Clan not found';            
                goto loadPage;
            } 

            if (!$errors) {
                $options = [
                    'cost' => \Components\Config::get('password_cost')
                ];
                $clan->master_password = password_hash($password, PASSWORD_BCRYPT, $options);
                $clan->master_password_fingerprint = md5(random_bytes(random_int(10,100)).$now->format('d-m-Y H:i:s'));
                $clan->save();
                $passwordChanged = true;
            }
        }

        loadPage:
        $this->view('password-reset', [
            'errors' => $errors,
            'passwordChanged' => $passwordChanged,
        ]);
        
    }

    public function deleteMapAndEverythingRelatedToIt($mapId) {
        $map = $this->clan->getMapOfClanById($mapId); 
        if (!$map) return;
        echo "<pre>";
        echo "Markers : ".count($map->markers).PHP_EOL;
        $picsCount = 0;
        foreach($map->markers as $marker) {
            $picsCount += count($marker->pics);
        }
        echo "Pics : ".$picsCount.PHP_EOL;

        foreach($map->markers as $marker) {
            foreach($marker->pics as $pic) {
                $pic->deleteFiles();
                $pic->delete(false);
            }
            $marker->delete(false);
        }

        if (!unlink(\Components\Config::get('folders')['maps'] . '/' . $map->map_filename)) {
            l($map->id." map ".$map->map_filename."deletion caused an error");
        }
            echo "deleted ".$map->map_filename."";
        
        $map->delete(false);
        $this->em->flush();
    }


}

