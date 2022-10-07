<?php

namespace App\Entity;

use App\Repository\PaiementFormationDispenseeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaiementFormationDispenseeRepository::class)
 */
class PaiementFormationDispensee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $datePaiement;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $montant;

    /**
     * @ORM\OneToOne(targetEntity=FormationDispensee::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $formationDispensee;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(\DateTimeInterface $datePaiement): self
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

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
