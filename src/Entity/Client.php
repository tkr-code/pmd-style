<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Idco
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $pays;




    /**
     * @ORM\OneToOne(targetEntity=PersonneGestion::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $personneGestion;

    /**
     * @ORM\OneToOne(targetEntity=Projet::class, mappedBy="client", cascade={"persist", "remove"})
     */
    private $projet;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

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

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(Projet $projet): self
    {
        // set the owning side of the relation if necessary
        if ($projet->getClient() !== $this) {
            $projet->setClient($this);
        }

        $this->projet = $projet;

        return $this;
    }
}
