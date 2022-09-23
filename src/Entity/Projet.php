<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjetRepository::class)
 */
class Projet
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
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $valeurTotal;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFinPrevu;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateFinRealisation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;


    /**
     * @ORM\OneToOne(targetEntity=Paiement::class, mappedBy="projet", cascade={"persist", "remove"})
     */
    private $paiement;

    /**
     * @ORM\OneToOne(targetEntity=Client::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=Collaborateur::class, mappedBy="projet")
     */
    private $collaborateur;

    public function __construct()
    {
        $this->collaborateur = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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

    public function getValeurTotal(): ?string
    {
        return $this->valeurTotal;
    }

    public function setValeurTotal(string $valeurTotal): self
    {
        $this->valeurTotal = $valeurTotal;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFinPrevu(): ?\DateTimeInterface
    {
        return $this->dateFinPrevu;
    }

    public function setDateFinPrevu(\DateTimeInterface $dateFinPrevu): self
    {
        $this->dateFinPrevu = $dateFinPrevu;

        return $this;
    }

    public function getDateFinRealisation(): ?\DateTimeInterface
    {
        return $this->dateFinRealisation;
    }

    public function setDateFinRealisation(?\DateTimeInterface $dateFinRealisation): self
    {
        $this->dateFinRealisation = $dateFinRealisation;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getPaiement(): ?Paiement
    {
        return $this->paiement;
    }

    public function setPaiement(Paiement $paiement): self
    {
        // set the owning side of the relation if necessary
        if ($paiement->getProjet() !== $this) {
            $paiement->setProjet($this);
        }

        $this->paiement = $paiement;

        return $this;
    }

    /**
     * @return Collection|Collaborateur[]
     */
    public function getCollaborateur(): Collection
    {
        return $this->collaborateur;
    }

    public function addCollaborateur(Collaborateur $collaborateur): self
    {
        if (!$this->collaborateur->contains($collaborateur)) {
            $this->collaborateur[] = $collaborateur;
            $collaborateur->setProjet($this);
        }

        return $this;
    }

    public function removeCollaborateur(Collaborateur $collaborateur): self
    {
        if ($this->collaborateur->removeElement($collaborateur)) {
            // set the owning side to null (unless already changed)
            if ($collaborateur->getProjet() === $this) {
                $collaborateur->setProjet(null);
            }
        }

        return $this;
    }

    
}
