<?php

namespace App\Entity;

use App\Repository\PaiementRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaiementRepository::class)
 */
class Paiement
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
     * @ORM\Column(type="date")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $montantTotal;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $montantVerse;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $montantDu;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estAcheve;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modePaiement;



    /**
     * @ORM\OneToMany(targetEntity=AvancePaiement::class, mappedBy="paiement",cascade={"remove"})
     */
    private $avance;

    /**
     * @ORM\OneToOne(targetEntity=Projet::class, inversedBy="paiement", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $projet;

    public function __construct()
    {
        $this->avance = new ArrayCollection();
        $this->dateCreation = new \DateTime();
    }

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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getMontantTotal(): ?string
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(string $montantTotal): self
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    public function getMontantVerse(): ?string
    {
        return $this->montantVerse;
    }

    public function setMontantVerse(string $montantVerse): self
    {
        $this->montantVerse = $montantVerse;

        return $this;
    }

    public function getMontantDu(): ?string
    {
        return $this->montantDu;
    }

    public function setMontantDu(string $montantDu): self
    {
        $this->montantDu = $montantDu;

        return $this;
    }

    public function getEstAcheve(): ?bool
    {
        return $this->estAcheve;
    }

    public function setEstAcheve(bool $estAcheve): self
    {
        $this->estAcheve = $estAcheve;

        return $this;
    }

    public function getModePaiement(): ?string
    {
        return $this->modePaiement;
    }

    public function setModePaiement(string $modePaiement): self
    {
        $this->modePaiement = $modePaiement;

        return $this;
    }

    /**
     * @return Collection|AvancePaiement[]
     */
    public function getAvance(): Collection
    {
        return $this->avance;
    }

    public function addAvance(AvancePaiement $avance): self
    {
        if (!$this->avance->contains($avance)) {
            $this->avance[] = $avance;
            $avance->setPaiement($this);
        }

        return $this;
    }

    public function removeAvance(AvancePaiement $avance): self
    {
        if ($this->avance->removeElement($avance)) {
            // set the owning side to null (unless already changed)
            if ($avance->getPaiement() === $this) {
                $avance->setPaiement(null);
            }
        }

        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(Projet $projet): self
    {
        $this->projet = $projet;

        return $this;
    }
}
