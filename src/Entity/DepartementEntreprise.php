<?php

namespace App\Entity;

use App\Repository\DepartementEntrepriseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepartementEntrepriseRepository::class)
 */
class DepartementEntreprise
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
    private $nombrePersonne;

    /**
     * @ORM\OneToOne(targetEntity=FormationDispensee::class, cascade={"persist", "remove"})
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

    public function getNombrePersonne(): ?int
    {
        return $this->nombrePersonne;
    }

    public function setNombrePersonne(int $nombrePersonne): self
    {
        $this->nombrePersonne = $nombrePersonne;

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
