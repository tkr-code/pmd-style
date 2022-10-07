<?php

namespace App\Entity;

use App\Repository\PointageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PointageRepository::class)
 */
class Pointage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreHeureDispense;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contenuDispense;

    /**
     * @ORM\Column(type="date")
     */
    private $datePointage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $esSupplementaire;

    /**
     * @ORM\ManyToOne(targetEntity=FormationDispensee::class, inversedBy="pointage")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formationDispensee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreHeureDispense(): ?int
    {
        return $this->nombreHeureDispense;
    }

    public function setNombreHeureDispense(int $nombreHeureDispense): self
    {
        $this->nombreHeureDispense = $nombreHeureDispense;

        return $this;
    }

    public function getContenuDispense(): ?string
    {
        return $this->contenuDispense;
    }

    public function setContenuDispense(string $contenuDispense): self
    {
        $this->contenuDispense = $contenuDispense;

        return $this;
    }

    public function getDatePointage(): ?\DateTimeInterface
    {
        return $this->datePointage;
    }

    public function setDatePointage(\DateTimeInterface $datePointage): self
    {
        $this->datePointage = $datePointage;

        return $this;
    }

    public function getEsSupplementaire(): ?bool
    {
        return $this->esSupplementaire;
    }

    public function setEsSupplementaire(bool $esSupplementaire): self
    {
        $this->esSupplementaire = $esSupplementaire;

        return $this;
    }

    public function getFormationDispensee(): ?FormationDispensee
    {
        return $this->formationDispensee;
    }

    public function setFormationDispensee(?FormationDispensee $formationDispensee): self
    {
        $this->formationDispensee = $formationDispensee;

        return $this;
    }
}
