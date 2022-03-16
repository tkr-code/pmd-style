<?php

namespace App\Entity;

use App\Repository\ReponseCahierChargeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReponseCahierChargeRepository::class)
 */
class ReponseCahierCharge
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
    private $reponse;

    /**
     * @ORM\ManyToOne(targetEntity=CahierCharge::class, inversedBy="reponses", cascade={"persist"}))
     * @ORM\JoinColumn(nullable=false)
     */
    private $cahierCharge;

    /**
     * @ORM\ManyToOne(targetEntity=QuestionCahierCharge::class, inversedBy="reponseCahierCharges", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getCahierCharge(): ?CahierCharge
    {
        return $this->cahierCharge;
    }

    public function setCahierCharge(?CahierCharge $cahierCharge): self
    {
        $this->cahierCharge = $cahierCharge;

        return $this;
    }

    public function getQuestion(): ?QuestionCahierCharge
    {
        return $this->question;
    }

    public function setQuestion(?QuestionCahierCharge $question): self
    {
        $this->question = $question;

        return $this;
    }
}
