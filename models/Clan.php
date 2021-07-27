<?php

namespace Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="clans")
 */
class Clan extends BaseModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /** @ORM\Column(type="string") */
    public $name;

    /** @ORM\Column(type="string") */
    public $email;

    /** @ORM\Column(type="string") */
    public $master_password;

    /** @ORM\Column(type="string") */
    public $master_password_fingerprint;

    /** @ORM\Column(type="string") */
    public $password;

    /** @ORM\Column(type="string") */
    public $password_fingerprint;

    /** @ORM\Column(type="string") */
    public $token;

    /** @ORM\Column(type="datetime") */
    public $cooldown;

    /** @ORM\Column(type="string") */
    public $email_confirmation_token;

    /** @ORM\Column(type="boolean", options={"default":0}) */
    public $email_confirmation = 0;

    /** @ORM\Column(type="integer") */
    public $current_map_id = 0;

    /** @ORM\Column(type="integer") */
    public $tier;

    /** @ORM\Column(type="string") */
    public $update_token;

    /** @ORM\Column(type="string") */
    public $update_folder;

    /** @ORM\Column(type="string") */
    public $custom_app_version;

    /** @ORM\OneToMany(targetEntity="\Models\Map", mappedBy="clan") */
    public $maps;

    /** @ORM\Column(type="boolean", options={"default":1}) */
    public $enabled = 1;

    /** @ORM\Column(type="datetime") */
    public $modified;

    /** @ORM\Column(type="datetime") */
    public $created;

    public function __construct() {
        parent::__construct();
        $now = new \DateTime();
        $this->modified = $now;
        $this->created = $now;
    }

    public static function getLoggedClanAndRole() {
        $em = \Components\EntityManagerGetter::getEntityManager();

        if (isset($_SESSION['clanId']) && isset($_SESSION['isMaster']) && isset($_SESSION['isUser'])) {
            $clan = \Models\Clan::find($_SESSION['clanId']);
            
            if ($_SESSION['isMaster']) { 
                if ($_SESSION['masterPasswordFingerprint'] !== $clan->master_password_fingerprint) {
                    session_unset();
                    redirect('/logout');
                }
            } elseif ($_SESSION['isUser']) {
                if ($_SESSION['passwordFingerprint'] !== $clan->password_fingerprint) {
                    session_unset();
                    redirect('/logout');
                }
            }
            return ['clan' => $clan, 'isMaster' => $_SESSION['isMaster'], 'isUser' => $_SESSION['isUser']];
        }

        if (empty($_COOKIE['clanName']) || empty($_COOKIE['password'])) {
            return ['clan' => null, 'isMaster' => false, 'isUser' => false];
        }

        $clan = $em->createQueryBuilder()
            ->select('c')
            ->from('Models\Clan', 'c')
            ->where("c.name = :clan AND c.master_password = :master_password")
            ->setParameters(['clan' => $_COOKIE['clanName'], 'master_password' => $_COOKIE['password']])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;


        if ($clan) {
            $clan->em = $em; 
            $_SESSION['clanId'] = $clan->id;
            $_SESSION['isMaster'] = true;
            $_SESSION['isUser'] = true;
            $_SESSION['masterPasswordFingerprint'] = $clan->master_password_fingerprint;
            return ['clan' => $clan, 'isMaster' => true, 'isUser' => true];
        }

        $clan = $em->createQueryBuilder()
            ->select('c')
            ->from('Models\Clan', 'c')
            ->where("c.name = :clan AND c.password = :password")
            ->setParameters(['clan' => $_COOKIE['clanName'], 'password' => $_COOKIE['password']])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;

        if ($clan) {
            $clan->em = $em; 
            $_SESSION['clanId'] = $clan->id;
            $_SESSION['isMaster'] = false;
            $_SESSION['isUser'] = true;
            $_SESSION['passwordFingerprint'] = $clan->password_fingerprint;
            return ['clan' => $clan, 'isMaster' => false, 'isUser' => true];
        }
        return ['clan' => null, 'isMaster' => false, 'isUser' => false];
    }


    public function getIdsOfMapsAsArray() {
        $mapIds = $this->em->createQueryBuilder()
            ->select('m.id')
            ->from('Models\Map', 'm')
            ->where("m.clan_id = :clan_id")
            ->setParameter('clan_id', $this->id)
            ->getQuery()
            ->getResult()
        ;
        $mapIds = array_column($mapIds, 'id');
        return $mapIds;

    }

    public function getMarkerOfClanById($markerId) {
        $marker = $this->em->createQueryBuilder()
            ->select('m')
            ->from('Models\Marker', 'm')
            ->where("m.id = :markerId AND m.clan_id = :clan_id")
            ->setParameters(['clan_id' => $this->id, 'markerId' => $markerId])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
        ;
        
        return $marker;
    }

    public function getMapOfClanById($mapId) {
        $map = $this->em->createQueryBuilder()
            ->select('m')
            ->from('Models\Map', 'm')
            ->where("m.id = :mapId AND m.clan_id = :clan_id")
            ->setParameters(['clan_id' => $this->id, 'mapId' => $mapId])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
        ;
        
        return $map;
    }

    public function itIsDemoClan() {
        if ($this->id === \Components\Config::get('demoClan')) {
            return true; 
        } else {
            return false;
        }
    }

    public function usedMarkers() {
        $usedMarkers = $this->em->createQueryBuilder()
            ->select('count(m.id) as count')
            ->from('Models\Marker', 'm')
            ->where("m.clan_id = :clan_id AND m.enabled = 1")
            ->setParameter('clan_id', $this->id)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;

        return $usedMarkers['count'];
    }

    public function totalMarkers() {
        return \Components\Config::get('tierMarkerCount')[$this->tier];
    }


}
