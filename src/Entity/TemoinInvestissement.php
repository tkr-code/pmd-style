<?php

namespace App\Entity;

use App\Repository\TemoinInvestissementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TemoinInvestissementRepository::class)
 */
class TemoinInvestissement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $signature;

    /**
     * @ORM\ManyToOne(targetEntity=Investissement::class, inversedBy="temoinInvestissement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $investissement;

    /**
     * @ORM\OneToOne(targetEntity=PersonneGestion::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $personneGestion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): self
    {
        $this->signature = $signature;

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

    public function getPersonneGestion(): ?PersonneGestion
    {
        return $this->personneGestion;
    }

    public function setPersonneGestion(PersonneGestion $personneGestion): self
    {
        $this->personneGestion = $personneGestion;

        return $this;
    }
}
