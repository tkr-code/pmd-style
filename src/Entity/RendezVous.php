<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RendezVousRepository::class)
 */
class RendezVous
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
    private $dateRdv;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu;

    /**
     * @ORM\Column(type="integer")
     */
    private $heure;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $objet;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=ClientRDV::class, inversedBy="rendezVous")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clientRDV;

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

    public function getDateRdv(): ?\DateTimeInterface
    {
        return $this->dateRdv;
    }

    public function setDateRdv(\DateTimeInterface $dateRdv): self
    {
        $this->dateRdv = $dateRdv;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getHeure(): ?int
    {
        return $this->heure;
    }

    public function setHeure(int $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

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

    public function getClientRDV(): ?ClientRDV
    {
        return $this->clientRDV;
    }

    public function setClientRDV(?ClientRDV $clientRDV): self
    {
        $this->clientRDV = $clientRDV;

        return $this;
    }

}
