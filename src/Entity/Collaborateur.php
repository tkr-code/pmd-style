<?php

namespace App\Entity;

use App\Entity\PersonneGestion;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CollaborateurRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=CollaborateurRepository::class)
 */
class Collaborateur
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
    private $apport;

    /**
     * @ORM\Column(type="integer")
     */
    private $niveauExcellence;

    /**
     * @ORM\OneToMany(targetEntity=Participation::class, mappedBy="collaborateur")
     */
    private $participation;

    /**
     * @ORM\OneToMany(targetEntity=Tache::class, mappedBy="collaborateur",cascade={"persist","remove"})
     */
    private $tache;



    /**
     * @ORM\ManyToOne(targetEntity=Projet::class, inversedBy="collaborateur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $projet;

    /**
     * @ORM\OneToOne(targetEntity=PersonneGestion::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $personneGestion;

    public function __construct()
    {
        $this->participation = new ArrayCollection();
        $this->tache = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApport(): ?string
    {
        return $this->apport;
    }

    public function setApport(string $apport): self
    {
        $this->apport = $apport;

        return $this;
    }

    public function getNiveauExcellence(): ?int
    {
        return $this->niveauExcellence;
    }

    public function setNiveauExcellence(int $niveauExcellence): self
    {
        $this->niveauExcellence = $niveauExcellence;

        return $this;
    }



    /**
     * @return Collection|Participation[]
     */
    public function getParticipation(): Collection
    {
        return $this->participation;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participation->contains($participation)) {
            $this->participation[] = $participation;
            $participation->setCollaborateur($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participation->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getCollaborateur() === $this) {
                $participation->setCollaborateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tache[]
     */
    public function getTache(): Collection
    {
        return $this->tache;
    }

    public function addTache(Tache $tache): self
    {
        if (!$this->tache->contains($tache)) {
            $this->tache[] = $tache;
            $tache->setCollaborateur($this);
        }

        return $this;
    }

    public function removeTache(Tache $tache): self
    {
        if ($this->tache->removeElement($tache)) {
            // set the owning side to null (unless already changed)
            if ($tache->getCollaborateur() === $this) {
                $tache->setCollaborateur(null);
            }
        }

        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;

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
    public function getFullName()
    {
        return $this->personneGestion->getNom() . ' ' . $this->personneGestion->getPrenom();
    }
}
