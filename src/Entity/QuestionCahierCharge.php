<?php

namespace App\Entity;

use App\Repository\QuestionCahierChargeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionCahierChargeRepository::class)
 */
class QuestionCahierCharge
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
    private $question;

    /**
     * @ORM\OneToMany(targetEntity=ReponseCahierCharge::class, mappedBy="question", orphanRemoval=true, cascade={"persist"}))
     */
    private $reponseCahierCharges;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    public function __construct()
    {
        $this->reponseCahierCharges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return Collection|ReponseCahierCharge[]
     */
    public function getReponseCahierCharges(): Collection
    {
        return $this->reponseCahierCharges;
    }

    public function addReponseCahierCharge(ReponseCahierCharge $reponseCahierCharge): self
    {
        if (!$this->reponseCahierCharges->contains($reponseCahierCharge)) {
            $this->reponseCahierCharges[] = $reponseCahierCharge;
            $reponseCahierCharge->setQuestion($this);
        }

        return $this;
    }

    public function removeReponseCahierCharge(ReponseCahierCharge $reponseCahierCharge): self
    {
        if ($this->reponseCahierCharges->removeElement($reponseCahierCharge)) {
            // set the owning side to null (unless already changed)
            if ($reponseCahierCharge->getQuestion() === $this) {
                $reponseCahierCharge->setQuestion(null);
            }
        }

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }
}
