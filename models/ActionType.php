<?php

namespace Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="action_types")
 */
class ActionType extends BaseModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /** @ORM\Column(type="integer") */
    public $type_id;

    /** @ORM\Column(type="string") */
    public $name;

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

}
