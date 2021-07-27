<?php

namespace Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pics")
 */
class Pic extends BaseModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /** @ORM\Column(type="string") */
    public $url;

    /** @ORM\Column(type="string") */
    public $preview = '';

    /** @ORM\Column(type="integer") */
    public $marker_id;

    /** @ORM\ManyToOne(targetEntity="\Models\Marker", inversedBy="pics") */
    public $marker;

    /** @ORM\Column(type="string") */
    public $usi;

    /** @ORM\Column(type="string") */
    public $ip;

    /** @ORM\Column(type="integer", options={"default":0}) */
    public $type = 0;

    /** @ORM\Column(type="integer", options={"default":0}) */
    public $ordering = 0;

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

    public static function getPicsForIncoming() {
        $em = \Components\EntityManagerGetter::getEntityManager();
        $usi = \Components\Storage::get('usi');
        $picTypesAllowedInIncomingColumn = [
            \Components\Config::get('picTypes')['fullScreen'],
            \Components\Config::get('picTypes')['centerScreen'],
            \Components\Config::get('picTypes')['stashSlots']
        ];

        $pics = $em->createQueryBuilder()
            ->select('p')
            ->from('Models\Pic', 'p')
            ->where("p.usi = :usi AND p.marker IS NULL AND p.enabled = 1 AND p.type IN (:picTypes)")
            ->setParameters(['usi' => $usi, 'picTypes' => $picTypesAllowedInIncomingColumn])
            ->getQuery()
            ->getResult()
        ;
        return $pics;
    }

    public function deleteFiles() {
        if (!unlink(\Components\Config::get('folders')['pic_uploads'].'/'.$this->url)) {
            l($this->id." picture ".$this->url." deletion caused an error");
        }

        if (!unlink(\Components\Config::get('folders')['pic_previews'].'/'.$this->preview)) {
            l($this->id." preview ".$this->preview." deletion caused an error");
        }
    }
}
