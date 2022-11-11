<?php

namespace App\Entity;

use App\Repository\InvestissementRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvestissementRepository::class)
 */
class Investissement
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
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $designation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

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
    private $date_fin;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $montantInvestissement;

    /**
     * @ORM\OneToMany(targetEntity=RetourInvestissement::class, mappedBy="investissement")
     */
    private $retourInvestissement;


    /**
     * @ORM\OneToMany(targetEntity=TemoinInvestissement::class, mappedBy="investissement")
     */
    private $temoinInvestissement;

    /**
     * @ORM\OneToOne(targetEntity=ContratInvestissement::class, inversedBy="investissement", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $contratInvestissement;

    /**
     * @ORM\ManyToOne(targetEntity=ContractantInvestissement::class, inversedBy="investissements", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $contractantInvestissement;


    public function __construct()
    {
        $this->retourInvestissement = new ArrayCollection();
        $this->temoinInvestissement = new ArrayCollection();
        $this->date_creation = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getMontantInvestissement(): ?string
    {
        return $this->montantInvestissement;
    }

    public function setMontantInvestissement(string $montantInvestissement): self
    {
        $this->montantInvestissement = $montantInvestissement;

        return $this;
    }

    /**
     * @return Collection|RetourInvestissement[]
     */
    public function getRetourInvestissement(): Collection
    {
        return $this->retourInvestissement;
    }

    public function addRetourInvestissement(RetourInvestissement $retourInvestissement): self
    {
        if (!$this->retourInvestissement->contains($retourInvestissement)) {
            $this->retourInvestissement[] = $retourInvestissement;
            $retourInvestissement->setInvestissement($this);
        }

        return $this;
    }

    public function removeRetourInvestissement(RetourInvestissement $retourInvestissement): self
    {
        if ($this->retourInvestissement->removeElement($retourInvestissement)) {
            // set the owning side to null (unless already changed)
            if ($retourInvestissement->getInvestissement() === $this) {
                $retourInvestissement->setInvestissement(null);
            }
        }

        return $this;
    }

    public function getContratInvestissement(): ?ContratInvestissement
    {
        return $this->contratInvestissement;
    }

    public function setContratInvestissement(?ContratInvestissement $contratInvestissement): self
    {
        $this->contratInvestissement = $contratInvestissement;

        return $this;
    }

    /**
     * @return Collection|TemoinInvestissement[]
     */
    public function getTemoinInvestissement(): Collection
    {
        return $this->temoinInvestissement;
    }

    public function addTemoinInvestissement(TemoinInvestissement $temoinInvestissement): self
    {
        if (!$this->temoinInvestissement->contains($temoinInvestissement)) {
            $this->temoinInvestissement[] = $temoinInvestissement;
            $temoinInvestissement->setInvestissement($this);
        }

        return $this;
    }

    public function removeTemoinInvestissement(TemoinInvestissement $temoinInvestissement): self
    {
        if ($this->temoinInvestissement->removeElement($temoinInvestissement)) {
            // set the owning side to null (unless already changed)
            if ($temoinInvestissement->getInvestissement() === $this) {
                $temoinInvestissement->setInvestissement(null);
            }
        }

        return $this;
    }

    public function getContractantInvestissement(): ?ContractantInvestissement
    {
        return $this->contractantInvestissement;
    }

    public function setContractantInvestissement(?ContractantInvestissement $contractantInvestissement): self
    {
        $this->contractantInvestissement = $contractantInvestissement;

        return $this;
    }
}
