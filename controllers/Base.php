<?php

namespace Controllers;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Base {


    public $clan;
    public $isMaster = null;
    public $isUser = null;
    public $isLoggedIn = null;
    public $em;

    public function __construct() {
        $userId = \Components\Storage::get('userId');

        if (!$userId && strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') !== 0) {
            $now = new \DateTime();
            $token = md5(random_bytes(random_int(10,100)).$now->format('d-m-Y H:i:s'));
            $userId = substr($token, 0, 15);
            \Components\Storage::set('userId', $userId);
            $this->userId = $userId;
            $data = [];
            $this->logAction(\Components\Config::get('actionTypes')['First visit the stashmap'],0,$data);
        }
        $this->userId = $userId;
        $this->em = \Components\EntityManagerGetter::getEntityManager();
        $clanData = \Models\Clan::getLoggedClanAndRole();
        $this->clan = $clanData['clan'];
        $this->isMaster = $clanData['isMaster'];
        $this->isUser = $clanData['isUser'];
        $this->isLoggedIn = $clanData['isUser'];
        $this->map = null;
        
        if ($this->clan) {
            $mapId = \Components\Storage::get('mapToPlayOn');
            $this->map = $this->clan->getMapOfClanById($mapId);
            if(!$this->map) {
                \Components\Storage::set('mapToPlayOn', \Components\Config::get('default_clan_map')); 
                $this->map = $this->clan->getMapOfClanById($this->clan->current_map_id);
            }
        }
    }

    public function view($template, $data = array()) {
        extract($data, EXTR_OVERWRITE);
        require ROOT . "/template/" . $template . '.php';
    }

    public function logAction($typeId = 0, $entityId = 0, $data = null, $userId = null) {
        $action = new \Models\Action();
        $action->user_id =  $userId ?? $this->userId;
        $action->entity_id = $entityId;
        $action->action_type_id  = $typeId;
        $action->ip = $_SERVER["REMOTE_ADDR"];
        $action->data = json_encode($data);
        $action->save();
    }

}
