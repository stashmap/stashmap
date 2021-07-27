<?php

namespace Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="actions")
 */
class Action extends BaseModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /** @ORM\Column(type="string") */
    public $user_id;
    
    /** @ORM\Column(type="integer") */
    public $action_type_id;

    /** @ORM\Column(type="string") */
    public $ip;
    
    /** @ORM\Column(type="string") */
    public $data;

    /** @ORM\Column(type="integer") */
    public $entity_id;
    
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