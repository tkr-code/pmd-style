<?php

namespace App\Entity;

use App\Repository\ContratInvestissementRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContratInvestissementRepository::class)
 */
class ContratInvestissement
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
     * @ORM\Column(type="date")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="date")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date")
     */
    private $date_echeance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numero_contrat;

    /**
     * @ORM\OneToOne(targetEntity=Investissement::class, mappedBy="contratInvestissement", cascade={"persist", "remove"})
     */
    private $investissement;

    public function __construct()
    {
        $this->date_creation = new DateTime();
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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateDebut(): ?string
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateEcheance(): ?\DateTimeInterface
    {
        return $this->date_echeance;
    }

    public function setDateEcheance(\DateTimeInterface $date_echeance): self
    {
        $this->date_echeance = $date_echeance;

        return $this;
    }

    public function getNumeroContrat(): ?string
    {
        return $this->numero_contrat;
    }

    public function setNumeroContrat(string $numero_contrat): self
    {
        $this->numero_contrat = $numero_contrat;

        return $this;
    }

    public function getInvestissement(): ?Investissement
    {
        return $this->investissement;
    }

    public function setInvestissement(Investissement $investissement): self
    {
        // set the owning side of the relation if necessary
        if ($investissement->getContratInvestissement() !== $this) {
            $investissement->setContratInvestissement($this);
        }

        $this->investissement = $investissement;

        return $this;
    }
}
