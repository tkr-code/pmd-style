<?php

namespace App\Entity;

use App\Repository\AvancePaiementRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvancePaiementRepository::class)
 */
class AvancePaiement
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
    private $dateCreation;

    /**
     * @ORM\Column(type="date")
     */
    private $dateAvance;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $montantAvance;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $montantDu;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estAtteint;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modePaiementAvance;

    /**
     * @ORM\ManyToOne(targetEntity=Paiement::class, inversedBy="avance")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paiement;
    public function __construct()
    {
        $this->dateCreation = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateAvance(): ?\DateTimeInterface
    {
        return $this->dateAvance;
    }

    public function setDateAvance(\DateTimeInterface $dateAvance): self
    {
        $this->dateAvance = $dateAvance;

        return $this;
    }

    public function getMontantAvance(): ?string
    {
        return $this->montantAvance;
    }

    public function setMontantAvance(string $montantAvance): self
    {
        $this->montantAvance = $montantAvance;

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

    public function getEstAtteint(): ?bool
    {
        return $this->estAtteint;
    }

    public function setEstAtteint(bool $estAtteint): self
    {
        $this->estAtteint = $estAtteint;

        return $this;
    }

    public function getModePaiementAvance(): ?string
    {
        return $this->modePaiementAvance;
    }

    public function setModePaiementAvance(string $modePaiementAvance): self
    {
        $this->modePaiementAvance = $modePaiementAvance;

        return $this;
    }

    public function getPaiement(): ?Paiement
    {
        return $this->paiement;
    }

    public function setPaiement(?Paiement $paiement): self
    {
        $this->paiement = $paiement;

        return $this;
    }
}
