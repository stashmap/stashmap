<?php

namespace Models;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class BaseModel {

    public $em;

    public function __construct() {
        $this->em = \Components\EntityManagerGetter::getEntityManager();
    }

    public function save($flush = true) {
        
        if (!$this->em) $this->em = \Components\EntityManagerGetter::getEntityManager();
        
        if ($this->id) {
            if (!empty($this->modified)) {
                $now = new \DateTime();
                $this->modified = $now;
            }
            $this->em->merge($this);
        } else {
            $this->em->persist($this);
        }
        if ($flush) $this->em->flush();
    }

    public function delete($flush = true) {
        if (!$this->em) $this->em = \Components\EntityManagerGetter::getEntityManager();
        $this->em->remove($this);
        if ($flush) $this->em->flush();
    }


    public static function find($id) {
        $em = \Components\EntityManagerGetter::getEntityManager();
        $class = get_called_class();
        $model = $em->find($class, (int) $id);
        if ($model) $model->em = $em;
        return $model;
    }



}
