<?php

namespace Controllers;

class Map extends Base {

    public function __construct() {
        parent::__construct();
    }

   function mail_utf8($to, $from_user, $from_email, $subject = '(No subject)', $message = '')
   {
      $from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
      $subject = "=?UTF-8?B?".base64_encode($subject)."?=";

      $headers = "From: $from_user <$from_email>\r\n".
               "MIME-Version: 1.0" . "\r\n" .
               "Content-type: text/html; charset=UTF-8" . "\r\n";

     return mail($to, $subject, $message, $headers);
   }

    public function lol() {
        $map = new \Models\Map();
        $map->name = 'aaaaaaaaaaaa';
        $map->map_filename = 'aaaaaaaaaa';
        $map->clan_id = $this->clan->id;

        v($map->clan_id);
        v($this->clan->id);
        $map->ip = '127.0.0.1';
        $map->enabled = 1;
        $map->save();
        v($map->clan_id);
        $map1 = \Models\Map::find(186);
        v($map1->clan_id);

        die;

        // $action = new \Models\Action();
        // $action->user_id = $this->userId;
        // $action->entity_id = 87;
        // $action->action_type_id  = 1;
        // $action->save();
        // die;

        // $actionType = new \Models\ActionType();
        // $actionType->name = 'some test type';
        // $actionType->save();
        // die;
        // \Components\Storage::set('mapToPlayOn', 114); 
        // echo \Components\Storage::get('mapToPlayOn');
        // die;

        $this->mail_utf8('fakreg@gmail.com', 'noreply','noreply@stashmap.net', 'Some subject', 's0me me$$age');
        echo "sended";
        die;

        // $to      = 'fakreg@gmail.com';
        // $subject = 'the subject';
        // $message = 'hello this is test';
        // $headers = 'From: noreply@stashmap.com' . "\r\n" .
        //     'X-Mailer: PHP/' . phpversion();

        // mail($to, $subject, $message, $headers);
        // die;

        
        \Components\Storage::set('usi', null);
        die;

        $pics = $this->em->createQueryBuilder()
            ->select('p')
            ->from('Models\Pic', 'p')
            ->getQuery()
            ->getResult();
        ;

        foreach($pics as $pic) {
        }
        
        vd('done');


        

        v(hrtime());
        $pic = \Models\Pic::find(73);
        v(hrtime());
        if ($pic) $pic->delete();
        v(hrtime());
        die;
    }

    public function getIncomingColumn() {
        //if (!$this->isLoggedIn) return;
        $usi = \Components\Storage::get('usi');

        if (!$usi) {
            $data = [
                'status' => 'NO USI',
                'incomingColumnHtml' => '',
                'incomingColumnHash' => '',
            ];
            echo json_encode($data);
            return true;
            
        }

        if (empty($_COOKIE['colPicWidth'])) { // cookie uses later by JS to set columns width
            \Components\Storage::set('colPicWidth', \Components\Config::get('pic_column_image_width_default'));            
        }

        if ($usi) {
            $pics = \Models\Pic::getPicsForIncoming();
            $pics = \Controllers\User::addGroupAndColorToPics($pics);
        }
        ob_start();
        $this->view('partial/incomingColumn', ['pics' => $pics]);
        $html = ob_get_contents();
        ob_end_clean();

        $data = [
            'status' => 'OK',
            'incomingColumnHtml' => $html,
            'incomingColumnHash' => md5($html),
        ];

        echo json_encode($data);
        return true;
        
    }



    public function getMarkerColumn($markerId = null) {
        if (!$this->isLoggedIn) return;        
        $ajaxId = $_POST['ajaxId'] ?? null;
        $refreshByClick = $_POST['refreshByClick'] ?? null;
        $markerId = $markerId ?: ($_POST['markerId'] ?? null);
        if (!$markerId || !$this->map) {
            $data = [
                'status' => 'OK',
                'markerColumnHtmlWithoutTimePanel' => '',
                'markerColumnHash' => '',
                'timePanelHtml' => '',
            ];
            echo json_encode($data);
            return;
        }
        
        $marker = $this->clan->getMarkerOfClanById($markerId);

        if (!$marker) {
            //no marker or it belongs to another clan
            $data = [
                'status' => 'OK',
                'markerColumnHtmlWithoutTimePanel' => '',
                'markerColumnHash' => '',
                'timePanelHtml' => '',
            ];
            echo json_encode($data);
            return;
        }

        $usi = \Components\Storage::get('usi');
        
        $picTypesAllowedInMarkerColumn = [
            \Components\Config::get('picTypes')['fullScreen'],
            \Components\Config::get('picTypes')['centerScreen'],
            \Components\Config::get('picTypes')['stashSlots']
        ];
        $pics = $this->em->createQueryBuilder()
            ->select('p')
            ->from('Models\Pic', 'p')
            ->where("p.marker = :marker AND p.enabled = 1 AND (p.type IN(:picTypes))")
            ->setParameters(['marker' => $marker, 'picTypes' => $picTypesAllowedInMarkerColumn])
            ->getQuery()
            ->getResult()
        ;

        ob_start();
        $this->view('partial/markerColumnWithoutTimePanel', [
            'pics' => $pics, 
            'usi' => $usi, 
            'marker' => $marker,
        ]);
        $markerColumnHtmlWithoutTimePanel = ob_get_contents();
        ob_end_clean();

        ob_start();
        $this->view('partial/timePanel', [
            'marker' => $marker,
        ]);

        $timePanelHtml = ob_get_contents();
        ob_end_clean();

        $totalMarkers = $this->clan->totalMarkers();
        $usedMarkers = $this->clan->usedMarkers();
        $showRemainMarkers = ((100 - $usedMarkers*100/$totalMarkers) < \Components\Config::get('showRemainMarkersIfLessThenPercent')) ? true : false;

        $data = [
            'status' => 'OK',
            'markerColumnHtmlWithoutTimePanel' => $markerColumnHtmlWithoutTimePanel,
            'markerColumnHash' => md5($markerColumnHtmlWithoutTimePanel),
            'timePanelHtml' => $timePanelHtml,
            'totalMarkers' => $totalMarkers,
            'usedMarkers' => $usedMarkers,
            'showRemainMarkers' => $showRemainMarkers,
            'ajaxId' => $ajaxId,
            'refreshByClick' => $refreshByClick,
        ];

        if ($refreshByClick) $this->logAction(\Components\Config::get('actionTypes')['Selecting a marker'], $marker->id, []);

        echo json_encode($data);
        return true;
    }

/*

MAP

*/
    public function map() {
        \Components\Storage::set('backTo_Label', 'Back to Map');
        \Components\Storage::set('backTo_Link', '/map');
        
        if (!$this->isLoggedIn) redirect ('/');
        
        if (empty($_COOKIE['colPicWidth'])) {
            \Components\Storage::set('colPicWidth', \Components\Config::get('pic_column_image_width_default'));            
        }

        $usi = \Components\Storage::get('usi');
        $pics = [];
        if ($usi) { 
            $pics = \Models\Pic::getPicsForIncoming();
            $pics = \Controllers\User::addGroupAndColorToPics($pics);
        }

        $data = [
            'usi' => $usi,
        ];
        $this->logAction(\Components\Config::get('actionTypes')['Visit a map'], $this->map->id ?? 0, $data);

        $this->view('map/map', ['pics' => $pics, 'usi' => $usi]);
        return true;
    }
    
    public function creation() {
        if (!$this->isLoggedIn) redirect ('/');

        $this->view('map/creation', []);
        return true;
    }    

    public function movePicsToMarker() {
        if (!$this->isLoggedIn) return;        
        $usi = \Components\Storage::get('usi');
        $markerId = (int)$_POST['markerId'] ?? null;
        $picIds = $_POST['picIds'] ?? null;
        $picIds = $picIds ? json_decode($picIds) : null;
        
        if (!$usi || !$picIds || !$markerId) {
            return;
        }

        $marker = $this->clan->getMarkerOfClanById($markerId);
        if (!$marker) return;
        if ($this->clan->itIsDemoClan()) {
            echo "No you can't!";
            return;            
        }
        

        $pics = $this->em->createQueryBuilder()
            ->select('p')
            ->from('Models\Pic', 'p')
            ->where("p.usi = :usi AND p.id IN (:picIds)")
            ->setParameters(['picIds' => $picIds, 'usi' => $usi])
            ->getQuery()
            ->getResult();
        ;

        if (!$pics) return;

        $picLatestDate = $pics[0]->created;
        foreach($pics as $pic) {
            $pic->marker = $marker;
            $pic->save();

            if ($picLatestDate > $pic->created) {
                $picLatestDate = $pic->create;
            }
        }

        $marker->refresh_time = $picLatestDate;
        $marker->save();

        $data = [
            'pics' => $picIds
        ];

        $this->logAction(\Components\Config::get('actionTypes')['Move pics to marker'], $markerId, $data);


        echo "OK";
        return;
        
    }

    public function movePicsToIncoming() {
        if (!$this->isLoggedIn) return;        
        $usi = \Components\Storage::get('usi');
        $picIds = $_POST['picIds'] ?? null;
        $picIds = $picIds ? json_decode($picIds) : null;
        
        if (!$usi || !$picIds) {
            echo "OK";
            return;
        }

        $pics = $this->em->createQueryBuilder()
                ->select('p')
                ->from('Models\Pic', 'p')
                ->where("p.usi = :usi AND p.id IN (:picIds)")
                ->setParameters(['picIds' => $picIds, 'usi' => $usi])
                ->getQuery()
                ->getResult();
        ;

        if (!$pics) return;

        $markerId = $pics[0]->marker->id;

        foreach($pics as $pic) {
            $pic->marker = null;
            $pic->save();
        }

        $data = [
            'pics' => $picIds
        ];

        $this->logAction(\Components\Config::get('actionTypes')['Move pics to incoming'], $markerId, $data);

        echo "OK";
        return;
        
    }

    public function deletePictures() {
        $usi = \Components\Storage::get('usi');
        $markerId = $_POST['markerId'] ?? null;
        $picIds = $_POST['picIds'] ?? null;
        $picIds = $picIds ? json_decode($picIds) : null;
        
        if (!$picIds) return;

        $marker = $this->clan ? $this->clan->getMarkerOfClanById($markerId) : null;
        $picsAreEitherAtIncomingOrTheyBelongToClan = ($markerId === '0' || ($markerId !== '0' && $marker));
        if (!$picsAreEitherAtIncomingOrTheyBelongToClan) return;

        if ($this->clan->itIsDemoClan()) {
            echo "No you can't!";
            return;            
        }

        $pics = $this->em->createQueryBuilder()
            ->select('p')
            ->from('Models\Pic', 'p')
            ->where("(p.marker_id = :markerId OR p.usi = :usi) AND p.id IN (:picIds)")
            ->setParameters(['picIds' => $picIds, 'markerId' => $markerId, 'usi' => $usi])
            ->getQuery()
            ->getResult();
        ;

        $data = [
            'pics' => $picIds
        ];

        $this->logAction(\Components\Config::get('actionTypes')['Delete pic'], $markerId, $data);
        
        foreach($pics as $pic) {
            $pic->deleteFiles();
            $pic->enabled = false;
            $pic->save();
        }

        if ($pics) {
            echo "OK";
            return;
        }
        
    }

    public function addMarker() {
        $errorData = ['status' => 'ERROR'];
        if (!$this->isLoggedIn || !$this->map) {
            echo json_encode($errorData);
            return;
        }
        $picIds = $_POST['picIds'] ?? null;
        $picIds = $picIds ? json_decode($picIds) : null;
        $lat = $_POST['lat'] ?? null;
        $lng = $_POST['lng'] ?? null;

        if (!$lat || !$lng) {
            echo json_encode($errorData);
            return;
        }


        if ($this->clan->itIsDemoClan()) {
            $errorData = ['status' => 'ERROR. it is a demo'];
            echo json_encode($errorData);
            return;            
        }

        $marker = new \Models\Marker();
        $marker->lat = (float)$lat;
        $marker->lng = (float)$lng;
        $marker->type = (int)$_POST['type'] ?? 0;
        $marker->refresh_time = new \DateTime();
        $marker->map = $this->map;
        $marker->clan_id = $this->clan->id;
        $marker->save();

        if ($picIds) {
            $usi = \Components\Storage::get('usi');
            $pics = $this->em->createQueryBuilder()
                ->select('p')
                ->from('Models\Pic', 'p')
                ->where("p.usi = :usi AND p.id IN (:picIds)")
                ->setParameters(['picIds' => $picIds, 'usi' => $usi])
                ->getQuery()
                ->getResult();
            ;

            $picLatestDateDate = (new \DateTime())->setTimestamp(0);
            foreach($pics as $pic) {
                $pic->marker_id = $marker->id;
                $pic->save(false);
                if ($picLatestDateDate < $pic->created) $picLatestDateDate = $pic->created;
            }
            $marker->refresh_time = $picLatestDateDate;
            $this->em->flush();

        }
        
        $data = [
            'status' => 'OK',
            'markerId' => $marker->id,
            'markerRefreshTime' => $marker->refresh_time->format(\Components\Config::get('date_format')),
        ];

        $logData = [
            'pics' => $picIds,
            'type' => $marker->type
        ];
        $this->logAction(\Components\Config::get('actionTypes')['Creating marker'], $marker->id, $logData);
        echo json_encode($data);
    }

    public function getMapMarkers() { 
        $errorData = ['status' => 'ERROR'];
        if (!$this->isLoggedIn) {
            echo json_encode($errorData);
            return;
        }
        $now = new \DateTime();
        $markers = \Models\Marker::getEnabledMarkersOfMapByMapId($this->map->id);
        $markersData = [];
        $markersStringForHash = '';
        foreach($markers as $marker) {
            $diffHours = ($now->getTimestamp() - $marker->refresh_time->getTimestamp())/3600;
            if ($diffHours < 18) {
                $lifePhase = 0;
            } elseif (($diffHours > 18) && ($diffHours < 36)) {
                $lifePhase = 1;
            } elseif (($diffHours > 36) && ($diffHours < 54)) {
                $lifePhase = 2;
            } elseif ($diffHours > 54) {
                $lifePhase = 3;
            }

            $markersStringForHash .= $marker->id.$marker->type.$lifePhase;

            $markersData[] = [
                'id' => $marker->id,
                'name' => $marker->name,
                'lat' => $marker->lat,
                'lng' => $marker->lng,
                'type' => $marker->type,
                'refreshTime' => $marker->refresh_time->format(\Components\Config::get('date_format')),
                'lifePhase' => $lifePhase
            ];
        }

        $data = [
            'status' => 'OK',
            'markers' => $markersData,
            'markersHash' => md5($markersStringForHash),
        ];
        echo json_encode($data);
    }

    public function deleteMarker() {
        if (!$this->isLoggedIn) return;        
        $markerId = $_POST['markerId'] ?? null;

        $marker = $this->clan->getMarkerOfClanById($markerId);

        if (!$marker) { 
            $data = [
                'status' => 'OK'
            ];
            echo json_encode($data);
            return;
        }

        if ($this->clan->itIsDemoClan()) {
            $data = [
                'status' => 'no you can\'t. It is a demo'
            ];
            echo json_encode($data);
            return;            
        }


        $marker->enabled = false;
        $marker->save();
        
        $this->logAction(\Components\Config::get('actionTypes')['Delete marker(disable)'], 0, []);

        $data = [
            'status' => 'OK'
        ];
        echo json_encode($data);
    }

    public function refreshMarker() {
        if (!$this->isLoggedIn) return;        
        $markerId = $_POST['markerId'] ?? null;
        
        $marker = $this->clan->getMarkerOfClanById($markerId);
        if (!$marker) return;

        $now = new \DateTime();
        $marker->refresh_time = $now;
        $marker->save();
        $data = [
            'status' => 'OK'
        ];
        echo json_encode($data);        
    }

    public function changeMarkerType() {
        if (!$this->isLoggedIn) return;        
        $markerId = $_POST['markerId'] ?? null;
        $type = $_POST['type'] ?? null;

        $marker = $this->clan->getMarkerOfClanById($markerId);
        if (!$marker) return;

        if (empty(\Components\Config::get('markerTypesAndTheirImages')[$type])) return;

        $logData = [
            'oldType' => $marker->type,
            'newType' => $type,
        ];
        $this->logAction(\Components\Config::get('actionTypes')['Marker type changing at marker'], $marker->id, $logData);

        $marker->type = $type;
        $marker->save();
        $data = [
            'status' => 'OK'
        ];
        echo json_encode($data);        
    }


    public function page($id=0) {
        
        $this->view('lol', ['id' => $id]);
        
    }

}
