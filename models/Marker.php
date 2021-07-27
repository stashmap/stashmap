<?php

namespace Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="markers")
 */
class Marker extends BaseModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /** @ORM\Column(type="string") */
    public $name;

    /** @ORM\Column(type="float") */
    public $lat;

    /** @ORM\Column(type="float") */
    public $lng;

    /** @ORM\Column(type="integer") */
    public $type = 0;

    /** @ORM\Column(type="datetime") */
    public $refresh_time;

    /** @ORM\Column(type="integer") */
    public $map_id;

    /** @ORM\ManyToOne(targetEntity="\Models\Map", inversedBy="markers") */
    public $map;

    /** @ORM\OneToMany(targetEntity="\Models\Pic", mappedBy="marker") */
    public $pics;

    /** @ORM\Column(type="integer") */
    public $clan_id;

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

    public static function getEnabledMarkersOfMapByMapId($mapId) {
        $em = \Components\EntityManagerGetter::getEntityManager();
        $markers = $em->createQueryBuilder()
            ->select('m')
            ->from('Models\Marker', 'm')
            ->where("m.map_id = :mapId AND m.enabled = true")
            ->setParameter('mapId', $mapId)
            ->getQuery()
            ->getResult()
        ;
        return $markers;
    }   

}
