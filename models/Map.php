<?php

namespace Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="maps")
 */
class Map extends BaseModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id = null;

    /** @ORM\Column(type="string") */
    public $name;

    /** @ORM\Column(type="string") */
    public $map_filename;

    /** @ORM\Column(type="integer") */
    public $clan_id;

    /** @ORM\ManyToOne(targetEntity="\Models\Clan", inversedBy="maps") */
    public $clan;

    /** @ORM\OneToMany(targetEntity="\Models\Marker", mappedBy="map") */
    public $markers;

    /** @ORM\Column(type="string") */
    public $ip;

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

    public static function getMapIdsOfClan($id) {
        $em = \Components\EntityManagerGetter::getEntityManager();
        $mapIds = $em->createQueryBuilder()
            ->select('m.id')
            ->from('Models\Map', 'm')
            ->where("m.clan_id = :clanId")
            ->setParameter('clanId', $id)
            ->getQuery()
            ->getResult()
        ;
        return array_column($mapIds, 'id');
    }    
    

}
