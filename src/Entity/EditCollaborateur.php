<?php

namespace App\Entity;

class EditCollaborateur
{
    private $nom;
    private $prenom;
    private $adresse;
    private $phone;
    private $Titre;
    private $email;
    private $avatar;
    private $apport;
    private $niveauExcellence;

    /**
     * Get the value of nom
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */
    public function setNom(string $nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */
    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of adresse
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     *
     * @return  self
     */
    public function setAdresse(string $adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get the value of phone
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of Titre
     */
    public function getTitre(): string
    {
        return $this->Titre;
    }

    /**
     * Set the value of Titre
     *
     * @return  self
     */
    public function setTitre(string $Titre)
    {
        $this->Titre = $Titre;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of avatar
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get the value of apport
     */
    public function getApport(): string
    {
        return $this->apport;
    }

    /**
     * Set the value of apport
     *
     * @return  self
     */
    public function setApport(string $apport)
    {
        $this->apport = $apport;

        return $this;
    }

    /**
     * Get the value of niveauExcellence
     */
    public function getNiveauExcellence(): int
    {
        return $this->niveauExcellence;
    }

    /**
     * Set the value of niveauExcellence
     *
     * @return  self
     */
    public function setNiveauExcellence(int $niveauExcellence)
    {
        $this->niveauExcellence = $niveauExcellence;

        return $this;
    }
}
