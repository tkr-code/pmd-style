<?php

namespace App\Entity;

use App\Repository\CentreFormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CentreFormationRepository::class)
 */
class CentreFormation
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
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $sigle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $specialite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToOne(targetEntity=PersonneGestion::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $personneGestion;

    /**
     * @ORM\OneToMany(targetEntity=ClasseFormation::class, mappedBy="centreFormation")
     */
    private $classeFormations;

    public function __construct()
    {
        $this->classeFormations = new ArrayCollection();
    }



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

    public function getSigle(): ?string
    {
        return $this->sigle;
    }

    public function setSigle(?string $sigle): self
    {
        $this->sigle = $sigle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

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

    public function getPersonneGestion(): ?PersonneGestion
    {
        return $this->personneGestion;
    }

    public function setPersonneGestion(PersonneGestion $personneGestion): self
    {
        $this->personneGestion = $personneGestion;

        return $this;
    }

    /**
     * @return Collection|ClasseFormation[]
     */
    public function getClasseFormations(): Collection
    {
        return $this->classeFormations;
    }

    public function addClasseFormation(ClasseFormation $classeFormation): self
    {
        if (!$this->classeFormations->contains($classeFormation)) {
            $this->classeFormations[] = $classeFormation;
            $classeFormation->setCentreFormation($this);
        }

        return $this;
    }

    public function removeClasseFormation(ClasseFormation $classeFormation): self
    {
        if ($this->classeFormations->removeElement($classeFormation)) {
            // set the owning side to null (unless already changed)
            if ($classeFormation->getCentreFormation() === $this) {
                $classeFormation->setCentreFormation(null);
            }
        }

        return $this;
    }
}
