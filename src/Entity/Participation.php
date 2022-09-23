<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipationRepository::class)
 */
class Participation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $present;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $absent;

    /**
     * @ORM\Column(type="date")
     */
    private $dateTravail;

    /**
     * @ORM\ManyToOne(targetEntity=Collaborateur::class, inversedBy="participation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $collaborateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresent(): ?bool
    {
        return $this->present;
    }

    public function setPresent(bool $present): self
    {
        $this->present = $present;

        return $this;
    }

    public function getAbsent(): ?bool
    {
        return $this->absent;
    }

    public function setAbsent(?bool $absent): self
    {
        $this->absent = $absent;

        return $this;
    }

    public function getDateTravail(): ?\DateTimeInterface
    {
        return $this->dateTravail;
    }

    public function setDateTravail(\DateTimeInterface $dateTravail): self
    {
        $this->dateTravail = $dateTravail;

        return $this;
    }

    public function getCollaborateur(): ?Collaborateur
    {
        return $this->collaborateur;
    }

    public function setCollaborateur(?Collaborateur $collaborateur): self
    {
        $this->collaborateur = $collaborateur;

        return $this;
    }
}
