<?php

namespace App\Entity;

use DateTime;

class EditProjet
{
    private $designation;
    private $description;
    private $type;
    private $dateDebut;
    private $dateFinPrevu;
    private $dateFinRealisation;
    private $etat;




    /**
     * Get the value of designation
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set the value of designation
     *
     * @return  self
     */
    public function setDesignation(string $designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of dateDebut
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set the value of dateDebut
     *
     * @return  self
     */
    public function setDateDebut(DateTime $dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get the value of dateFinPrevu
     */
    public function getDateFinPrevu()
    {
        return $this->dateFinPrevu;
    }

    /**
     * Set the value of dateFinPrevu
     *
     * @return  self
     */
    public function setDateFinPrevu(DateTime $dateFinPrevu)
    {
        $this->dateFinPrevu = $dateFinPrevu;

        return $this;
    }

    /**
     * Get the value of etat
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set the value of etat
     *
     * @return  self
     */
    public function setEtat(string $etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get the value of dateFinRealisation
     */ 
    public function getDateFinRealisation()
    {
        return $this->dateFinRealisation;
    }

    /**
     * Set the value of dateFinRealisation
     *
     * @return  self
     */ 
    public function setDateFinRealisation($dateFinRealisation)
    {
        $this->dateFinRealisation = $dateFinRealisation;

        return $this;
    }
}
