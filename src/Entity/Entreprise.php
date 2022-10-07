<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $designation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroNinea;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domaineActivite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToOne(targetEntity=Personnegestion::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $personneGestion;

    /**
     * @ORM\OneToOne(targetEntity=FormationDispensee::class, inversedBy="entreprise", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $formationDispensee;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getNumeroNinea(): ?string
    {
        return $this->numeroNinea;
    }

    public function setNumeroNinea(string $numeroNinea): self
    {
        $this->numeroNinea = $numeroNinea;

        return $this;
    }

    public function getDomaineActivite(): ?string
    {
        return $this->domaineActivite;
    }

    public function setDomaineActivite(string $domaineActivite): self
    {
        $this->domaineActivite = $domaineActivite;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPersonneGestion(): ?Personnegestion
    {
        return $this->personneGestion;
    }

    public function setPersonneGestion(Personnegestion $personneGestion): self
    {
        $this->personneGestion = $personneGestion;

        return $this;
    }

    public function getFormationDispensee(): ?FormationDispensee
    {
        return $this->formationDispensee;
    }

    public function setFormationDispensee(FormationDispensee $formationDispensee): self
    {
        $this->formationDispensee = $formationDispensee;

        return $this;
    }

}
