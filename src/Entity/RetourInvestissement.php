<?php

namespace App\Entity;

use App\Repository\RetourInvestissementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RetourInvestissementRepository::class)
 */
class RetourInvestissement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $montant_recu;

    /**
     * @ORM\Column(type="date")
     */
    private $date_reception;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estRecuperer;

    /**
     * @ORM\ManyToOne(targetEntity=Investissement::class, inversedBy="retourInvestissement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $investissement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantRecu(): ?string
    {
        return $this->montant_recu;
    }

    public function setMontantRecu(string $montant_recu): self
    {
        $this->montant_recu = $montant_recu;

        return $this;
    }

    public function getDateReception(): ?\DateTimeInterface
    {
        return $this->date_reception;
    }

    public function setDateReception(\DateTimeInterface $date_reception): self
    {
        $this->date_reception = $date_reception;

        return $this;
    }

    public function getEstRecuperer(): ?bool
    {
        return $this->estRecuperer;
    }

    public function setEstRecuperer(bool $estRecuperer): self
    {
        $this->estRecuperer = $estRecuperer;

        return $this;
    }

    public function getInvestissement(): ?Investissement
    {
        return $this->investissement;
    }

    public function setInvestissement(?Investissement $investissement): self
    {
        $this->investissement = $investissement;

        return $this;
    }
}
