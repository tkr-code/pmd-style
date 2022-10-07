<?php

namespace App\Entity;

use App\Repository\ClasseFormationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClasseFormationRepository::class)
 */
class ClasseFormation
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
     * @ORM\Column(type="integer")
     */
    private $nombreEtudiant;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $abreviation;

    /**
     * @ORM\OneToOne(targetEntity=FormationDispensee::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $formationDispensee;

    /**
     * @ORM\ManyToOne(targetEntity=CentreFormation::class, inversedBy="classeFormations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $centreFormation;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $niveauEtude;

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

    public function getNombreEtudiant(): ?int
    {
        return $this->nombreEtudiant;
    }

    public function setNombreEtudiant(int $nombreEtudiant): self
    {
        $this->nombreEtudiant = $nombreEtudiant;

        return $this;
    }

    public function getAbreviation(): ?string
    {
        return $this->abreviation;
    }

    public function setAbreviation(?string $abreviation): self
    {
        $this->abreviation = $abreviation;

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

    public function getCentreFormation(): ?CentreFormation
    {
        return $this->centreFormation;
    }

    public function setCentreFormation(?CentreFormation $centreFormation): self
    {
        $this->centreFormation = $centreFormation;

        return $this;
    }

    public function getNiveauEtude(): ?string
    {
        return $this->niveauEtude;
    }

    public function setNiveauEtude(string $niveauEtude): self
    {
        $this->niveauEtude = $niveauEtude;

        return $this;
    }
}
