<?php
namespace App\Entity;

class AddTacheCollection {
    private $tache;

    /**
     * Get the value of tache
     */ 
    public function getTache()
    {
        return $this->tache;
    }

    /**
     * Set the value of tache
     *
     * @return  self
     */ 
    public function setTache($tache)
    {
        $this->tache = $tache;

        return $this;
    }
}