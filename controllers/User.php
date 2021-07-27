<?php

namespace Controllers;

class User extends Base {

    public function __construct() {
        parent::__construct();
    }

    public static function addGroupAndColorToPics($pics) {
        if (!$pics) return $pics;

        $sameGroupSeconds = \Components\Storage::get('groupTime')?:\Components\Config::get('within_one_group_seconds'); // \Components\Config::get('within_one_group_seconds') --> if next pic was created less then 40sec after previous pic, then they in one group
        $colorScheme = \Components\Storage::get('colorScheme')?:\Components\Config::get('color_scheme_default'); 
        $colors = \Components\Config::get('color_schemes_incoming')[$colorScheme];
        $colorsCount = count($colors);
        $colorIndex = 0;
        $groupNum = 0;
        $date = $pics[0]->created;
        foreach($pics as $key => $pic) {
            $diffSeconds = $pic->created->getTimestamp() - $date->getTimestamp();
            if ($diffSeconds > $sameGroupSeconds) {
                $groupNum++;
                $colorIndex = $groupNum - intdiv($groupNum, $colorsCount) * $colorsCount;
            }
            $date = $pic->created;
            $pics[$key]->group = 'group_'.$groupNum; 
            $pics[$key]->color = $colors[$colorIndex];
        }
        return $pics;
    }

    public function settings() {


        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') === 0) {

            $showTooltips = $_POST['showTooltips'] ?? null;
            $doNotShowTooltips = !(bool)$showTooltips;
            \Components\Storage::set('doNotShowTooltips',$doNotShowTooltips);

            $usi = $_POST['usi'] ?? null;
            if ($usi !== null) {
                if ($usi === '') {
                    \Components\Storage::set('usi',null);
                } else {
                    \Components\Storage::set('usi',$usi);
                    $this->logAction(\Components\Config::get('actionTypes')['Setting an USI'], 0, ['usi' => $usi]);
                }
            }

            $colWidth = $_POST['colWidth'] ?? null;
            if ($colWidth && in_array((int)$colWidth,\Components\Config::get('pic_column_image_width_options'))) {
                \Components\Storage::set('colPicWidth',$colWidth);
                $this->logAction(\Components\Config::get('actionTypes')['Setting preview size'], 0, ['previewSize' => $colWidth]);
            }
            
            $pictureWidth = $_POST['pictureWidth'] ?? null;
            if ($pictureWidth && in_array($pictureWidth,\Components\Config::get('pictureWidthOptions'))) {
                \Components\Storage::set('pictureWidth',$pictureWidth);
                $this->logAction(\Components\Config::get('actionTypes')['Setting picture size'], 0, ['pictureSize' => $pictureWidth]);
            }

            $groupTime = $_POST['groupTime'] ?? null;
            if ($groupTime) {
                \Components\Storage::set('groupTime',$groupTime);
                $this->logAction(\Components\Config::get('actionTypes')['Setting grouping seconds'], 0, ['groupTime' => $groupTime]);
            }
            
            $colorScheme = $_POST['colorScheme'] ?? null;
            if (array_key_exists ($colorScheme,\Components\Config::get('color_schemes_incoming'))) {
                \Components\Storage::set('colorScheme',$colorScheme);
                $this->logAction(\Components\Config::get('actionTypes')['Setting color scheme'], 0, ['colorScheme' => $colorScheme]);
            }

            $backgroundImage = $_POST['backgroundImage'] ?? null;
            if (array_key_exists ($backgroundImage,\Components\Config::get('backgroundImages'))) {
                \Components\Storage::set('backgroundImage',$backgroundImage);
                $this->logAction(\Components\Config::get('actionTypes')['Setting an USI'], 0, ['backgroundImage' => $backgroundImage]);
            }

            $bodyGradientColorTop = $_POST['bodyGradientColorTop'] ?? null;
            if ($bodyGradientColorTop !== null) {
                \Components\Storage::set('bodyGradientColorTop',$bodyGradientColorTop);
                $this->logAction(\Components\Config::get('actionTypes')['Setting top gradient'], 0, ['bodyGradientColorTop' => $bodyGradientColorTop]);
            }

            $bodyGradientColorBottom = $_POST['bodyGradientColorBottom'] ?? null;
            if ($bodyGradientColorBottom !== null) {
                \Components\Storage::set('bodyGradientColorBottom',$bodyGradientColorBottom);
                $this->logAction(\Components\Config::get('actionTypes')['Setting bottom gradient'], 0, ['bodyGradientColorBottom' => $bodyGradientColorBottom]);
            }

            $mapId = $_POST['mapId'] ?? null;
            if ($mapId && in_array($mapId, $this->clan->getIdsOfMapsAsArray()) || $mapId === \Components\Config::get('default_clan_map')) {
                \Components\Storage::set('mapToPlayOn', $mapId);
            }

            $sidepanelOpacity = $_POST['sidepanelOpacity'] ?? null;
            if (array_key_exists($sidepanelOpacity, \Components\Config::get('sidepanelOpacityOptions'))) {
                \Components\Storage::set('sidepanelOpacity', $sidepanelOpacity);
                $this->logAction(\Components\Config::get('actionTypes')['Setting sidepanel opacity'], 0, ['sidepanelOpacity' => $sidepanelOpacity]);
            }

            redirect(\Components\Storage::get('backTo_Link'));            
        };
        
        $this->logAction(\Components\Config::get('actionTypes')['Visit settings page'], 0, []);
        
        //\Components\Storage::set('settingsEverOpened', 1);
        $this->view('settings',[
            'usi' => \Components\Storage::get('usi'),
            'maps' => $this->isLoggedIn ? $this->clan->maps : null, 
            ]);

    }

    public function faq() {
        $this->logAction(\Components\Config::get('actionTypes')['Visit faq page'], 0, []);
        
        $this->view('faq',[
            ]);

    }    

    public function addPictureByAppFile() {

        $usi = $_POST['usi'] ?? null;
        if ( !$usi) {
            echo 'Error! No usi received';
            $this->logAction(\Components\Config::get('actionTypes')['Uploading image. Error : no usi given'], 0, []);
            return;
        }

        $ip = $_SERVER["REMOTE_ADDR"];
        $now = new \DateTime();
        $datetimestamp = $now->sub(new \DateInterval('PT'.\Components\Config::get('upload')['pic']['period_in_minutes'].'M'));

        $pics = $this->em->createQueryBuilder()
            ->select('p.id')
            ->from('Models\Pic', 'p')
            ->where("p.ip = :ip AND p.created > :dat ")
            ->setParameters(['ip' => $ip, 'dat' => $datetimestamp])
            ->getQuery()
            ->getResult();
        ;

        if (count($pics) >= \Components\Config::get('upload')['pic']['allowed_quantity_at_period']) {
            echo 'Too many screenshots. Try later';
            $this->logAction(\Components\Config::get('actionTypes')['Uploading  image. Error : too many screenshots. Try later'], 0, []);
            return;
        }

        if (empty($_FILES["fileToUpload"])) return;
        $filename = bin2hex(random_bytes(5)) . '_'. basename($_FILES["fileToUpload"]["name"]);
        $targetFile = \Components\Config::get('folders')['pic_uploads'].'/'.$filename;
        
        // Check if image file is a actual image or fake image
        $imageSize = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($imageSize === false) {
            echo "Error. File not image";
            $this->logAction(\Components\Config::get('actionTypes')['Uploading  image. Error : file not image'], 0, []);
            return;
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "ERROR";
            return;
        }

        $destination = $_POST['destination'] ?? null;
        if ($destination === \Components\Config::get('picTypes')['mapPart'] ) {
            $allowedSize = \Components\Config::get('upload')['pic']['map_part_max_file_size'];
        } else {
            $allowedSize = \Components\Config::get('upload')['pic']['screenshot_max_file_size'];
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > $allowedSize) {
            echo "Error! File too large";
            $data = [
                'fileSize' => $_FILES["fileToUpload"]["size"]
            ];
            $this->logAction(\Components\Config::get('actionTypes')['Uploading  image. Error : file too large'], 0, $data);
            return;
        }
        
        // Allow certain file formats
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Error! Png or jpg only";
            $data = [
                'filename' => $filename
            ];
            $this->logAction(\Components\Config::get('actionTypes')['Uploading image. Error : file not png or jpg'], 0, $data);
            return;
        }

        if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo "Error!";
            
            $data = [
                'fileSize' => $_FILES["fileToUpload"]["size"],
                'filename' => $filename
            ];
            $this->logAction(\Components\Config::get('actionTypes')['Uploading image. Error : moving file fail'], 0, $data);
            return;
        }

        $pic = new \Models\Pic();

        // if ($destination === \Components\Config::get('upload')['pic']['type']['map_part']) {
        //     $pic->type = \Components\Config::get('picTypes')['mapPart'];
        // }



        $pic->type = $destination;
        $pic->url = $filename;
        $pic->usi = $usi;
        $pic->ip = $ip;
        $pic->marker = null;
        $pic->enabled = true;
        $pic->save();

        $preview = \Components\Previewer::makePreviewFromPicUrlAndId($targetFile, $pic->id);

        $pic->preview = $preview;
        $pic->save();

        $logData = [
            'fileSize' => $_FILES["fileToUpload"]["size"],
            'filename' => $filename,
            'width' => $imageSize[0],
            'height' => $imageSize[1],
        ];
        if ($destination === \Components\Config::get('picTypes')['fullScreen']) $this->logAction(\Components\Config::get('actionTypes')['Uploading image as entire screen'], $pic->id, $logData, $usi);
        if ($destination === \Components\Config::get('picTypes')['centerScreen']) $this->logAction(\Components\Config::get('actionTypes')['Uploading image as center'], $pic->id, $logData, $usi);
        if ($destination === \Components\Config::get('picTypes')['stashSlots']) $this->logAction(\Components\Config::get('actionTypes')['Uploading image as stash slots'], $pic->id, $logData, $usi);
        if ($destination === \Components\Config::get('picTypes')['mapPart']) $this->logAction(\Components\Config::get('actionTypes')['Uploading image as map-part'], $pic->id, $logData, $usi);

        if ($destination === \Components\Config::get('picTypes')['mapPart']) {
            //delete all files and pictures of this clan as mappart except last two
            $pics = $this->em->createQueryBuilder()
                ->select('p')
                ->from('Models\Pic', 'p')
                ->where("p.usi = :usi AND p.enabled = 1 AND p.type = :pic_type_as_map_part")
                ->orderBy('p.id', 'DESC')
                ->setParameters(['usi' => $usi, 'pic_type_as_map_part' => \Components\Config::get('picTypes')['mapPart']])
                ->getQuery()
                ->getResult()
            ;

            for($i = 0; $i < count($pics); $i++) {
                if ( $i >= \Components\Config::get('number_of_pics_required_to_create_a_map')) {
                    $pics[$i]->deleteFiles();
                    $pics[$i]->delete();
                }
            }
        }

        if ($preview === \Components\Config::get('pic_preview_error_filename')) {
            echo 'Error! Preview not created';
            $this->logAction(\Components\Config::get('actionTypes')['Uploading image. Error : preview not created'], 0, []);
        } else {
            echo 'OK';
        }

        return;
    }    

    public function getHourDiffBetweenUserAndServer() {
        $datetime = $_POST['datetime'] ?? null;
        $userDate = \DateTime::createFromFormat('Y-m-d H:i:s', $datetime);
        $serverDate = new \DateTime();
        $diff = date_diff($serverDate, $userDate);
        $hourDiff = round(($diff->h*60+$diff->i)/60);
        $hourDiff = $diff->invert ? -1*$hourDiff : $hourDiff;

        $data = [
            'status' => 'OK',
            'hourDiff' => $hourDiff
        ];
        echo json_encode($data);
        
    }

    public function cookies() {
        $this->view('cookie');
    }

    public function cookieDelete() {
        $cookieKey = $_POST['cookie'] ?? null;

        if (isset($_COOKIE[$cookieKey])) {
            
            unset($_SESSION[$cookieKey]);
            unset($_COOKIE[$cookieKey]);
            setcookie($cookieKey, null, time() - 60 , '/');            
            $data = [
                'status' => 'OK',
                'cookie' => $cookieKey,
            ];
        } else {
            $data = [
                'status' => 'NO COOKIE',
                'cookie' => $cookieKey,
            ];
        }

        echo json_encode($data);        

    }

    public function session() {
        $this->view('session');
    }

    public function sessionDelete() {
        $sessionKey = $_POST['session'] ?? null;

        if (isset($_SESSION[$sessionKey])) {
            unset($_SESSION[$sessionKey]);
            $data = [
                'status' => 'OK',
            ];
        } else {
            $data = [
                'status' => 'NO SESSION',
            ];
        }

        echo json_encode($data);        

    }
    

    public function patreon() {
        ob_start();
        v($_POST);
        $text = ob_get_contents();
        ob_end_clean();
        l($text);
    }

    public function updateCheck() {
        $updateToken = $_POST['updateToken'] ?? null;
        $appVersion = $_POST['version'] ?? null;

        if (!$appVersion) return;

        if ($updateToken) {
            $clan = $this->em->createQueryBuilder()
                ->select('c')
                ->from('Models\Clan', 'c')
                ->where("c.update_token = :updateToken")
                ->setParameters(['updateToken' => $updateToken])
                ->getQuery()
                ->setMaxResults(1)
                ->getOneOrNullResult()
            ;

            if (!$clan) goto simpleVersionCheck;
            if (!$clan->custom_app_version) goto simpleVersionCheck;
            if (version_compare($clan->custom_app_version, \Components\Config::get('stashpicLatestVersion')) === -1) goto simpleVersionCheck;
            if (version_compare($clan->custom_app_version, $appVersion) < 1) goto simpleVersionCheck;
           
            echo "new_version_available";
            return;
        }

        simpleVersionCheck:
        if (version_compare(\Components\Config::get('stashpicLatestVersion'), $appVersion) === 1) {
            echo "new_version_available";
            return;
        }

        echo "you_have_latest_version";

    }

    public function update() {
        $updateToken = $_POST['updateToken'] ?? null;
        $clanCustomFolder = '';
        if ($updateToken) {
            $clan = $this->em->createQueryBuilder()
                ->select('c')
                ->from('Models\Clan', 'c')
                ->where("c.update_token = :updateToken")
                ->setParameters(['updateToken' => $updateToken])
                ->getQuery()
                ->setMaxResults(1)
                ->getOneOrNullResult()
            ;

            if (!$clan) goto simpleVersionUpdate;
            if (!$clan->custom_app_version) goto simpleVersionUpdate;
            if (version_compare($clan->custom_app_version, \Components\Config::get('stashpicLatestVersion')) === -1) goto simpleVersionUpdate;

            $clanCustomFolder = '/'.$clan->update_folder;
        }

        simpleVersionUpdate:

        $files = [
            'stashpic' => [
                'fileLink' => 'http://stashmap.net/content/stashpic'.$clanCustomFolder.'/StashPic.exe',
                'filePlace' => 'StashPic.exe',
            ],
            'shutter sound' => [
                'fileLink' => 'http://stashmap.net/content/stashpic'.$clanCustomFolder.'/media/shutter.wav',
                'filePlace' => 'media\shutter.wav',
            ],
            'error sound' => [
                'fileLink' => 'http://stashmap.net/content/stashpic'.$clanCustomFolder.'/media/error.wav',
                'filePlace' => 'media\error.wav',
            ],

        ];

        $data = [
            // 'status' => 'OK',
            // 'updateToken' => $updateToken,
            'files' => $files,
        ];
        echo json_encode($data);
    }


    public function stashpic() {
        $regex = "/^([0-9]+)\.([0-9]+)\.([0-9]+)/"; 
        preg_match($regex, \Components\Config::get('stashpicLatestVersion'), $matches);

        $this->view('stashpic', [
            'version' => $matches[0]
        ]);
    }

    public function speedDial() {
        $this->logAction(\Components\Config::get('actionTypes')['Visit speed-dial'], 0, []);
        $this->view('speed-dial', [
        ]);
    }

    public function usi($usi) {
        if (!$usi) redirect('/');
        \Components\Storage::set('usi',$usi);
        $this->logAction(\Components\Config::get('actionTypes')['Setting USI by app link'], 0, ['usi' => $usi]);
        if ($this->isLoggedIn) redirect('/map');
        redirect('/screenshots');
    }

    public function screenshots() {
        if ($this->isLoggedIn) redirect('/map');
        \Components\Storage::set('backTo_Label', 'Back to Screenshots');
        \Components\Storage::set('backTo_Link', '/screenshots');

        if (empty($_COOKIE['colPicWidth'])) {
            \Components\Storage::set('colPicWidth', \Components\Config::get('pic_column_image_width_default'));            
        }

        $usi = \Components\Storage::get('usi');
        $pics = [];
        if ($usi) { 
            $pics = \Models\Pic::getPicsForIncoming();
            $pics = \Controllers\User::addGroupAndColorToPics($pics);
        }
        $this->view('screenshots', ['pics' => $pics, 'usi' => $usi]);
        return true;
    }

    public function followingLink() {
        $link = $_POST['link'] ?? null;
        if (array_key_exists($link, \Components\Config::get('linkClickLeadToActions'))) {
            $action = \Components\Config::get('linkClickLeadToActions')[$link];
            $this->logAction(\Components\Config::get('actionTypes')[$action], 0, []);
        }

        $data = [
            'status' => 'OK'
        ];
        echo json_encode($data);
        return;
    }

    public function logMarkerChangeType() {
        $type = $_POST['defaultMarkerType'] ?? null;
        if (array_key_exists($type, \Components\Config::get('defaultMarkerTypesAndTheirImages'))) {
            $data = [
                'type' => $type
            ];
            $this->logAction(\Components\Config::get('actionTypes')['Marker type changing at sidepanel'], 0, $data);
        }

        $data = [
            'status' => 'OK'
        ];
        echo json_encode($data);
        return;
    }

    public function test1() {

        
        $usedMarkers = $this->em->createQueryBuilder()
            ->select('count(m.id) as count')
            ->from('Models\Marker', 'm')
            ->where("m.clan_id = :clan_id AND m.enabled = 1")
            ->setParameter('clan_id', $this->clan->id)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;

        $usedMarkers = $usedMarkers['count'];

        vd($usedMarkers);

        



        $clan = $em->createQueryBuilder()
            ->select('c')
            ->from('Models\Clan', 'c')
            ->where("c.id = :id")
            ->setParameter('id', 22)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;

        vd($clan->em);
        die;

        $picIds = ['3414'];

        foreach($picIds as $picId) {
            $pic = \Models\Pic::find($picId);
            if (!$pic) echo "no pic";
            $pic->deleteFiles();
            $pic->delete();
        }

        die;
        $marker = \Models\Marker::find(632);
        $clan = \Models\Clan::find(22);
        $map = \Models\Clan::find($clan->current_map_id);
        echo memory_get_usage();
        die;
        // startTimeMeasure();
        for($j=1;$j<=1;$j++) {
            for($i=1;$i<=632;$i++) {
                $marker = $this->clan->getMarkerOfClanById($i);
                
                // $marker = $this->clan->ownsTheMarker($i);
                // $marker = \Models\Marker::find($marker);
            }
        }
        // stopTimeMeasure();
        echo memory_get_usage();

        die;
        echo $this->clan->id;
        die;
        // find clan. get maps of clan
        $clan = \Models\Clan::find(22);
        echo "<pre>";
        echo count($clan->maps).PHP_EOL;
        foreach($clan->maps as $map) {
            echo $map->name.PHP_EOL;
        }
        die;        

        // find map. get clan of map. show that clan name
        $map = \Models\Map::find(98);
        echo $map->clan->name;
        die;

        // find marker. get pics of marker
        $marker = \Models\Marker::find(503);
        echo "<pre>";
        echo count($marker->pics).PHP_EOL;
        foreach($marker->pics as $pic) {
            echo $pic->url.PHP_EOL;
        }
        die;

        // find marker. get map of marker. show that map name
        $marker = \Models\Marker::find(503);
        echo $marker->map->name;
        die;

        // find map. show all markers of map
        $map = \Models\Map::find(98);
        echo "<pre>";
        echo $map->id.$map->name.PHP_EOL;

        echo count($map->markers).PHP_EOL;
        foreach($map->markers as $marker) {
            echo $marker->id.PHP_EOL;
        }


    }


    public function userActions() {
        if ($this->clan->id !== \Components\Config::get('ClanIdWithAnalyticPermission')) redirect('/');

        
        echo "secretpage";

    }



}
