<?php

namespace App\Entity;

use App\Repository\ContractantInvestissementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContractantInvestissementRepository::class)
 */
class ContractantInvestissement
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
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codePostal;
    

    /**
     * @ORM\OneToOne(targetEntity=PersonneGestion::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $personneGestion;

    /**
     * @ORM\OneToMany(targetEntity=Investissement::class, mappedBy="contractantInvestissement",cascade={"remove"})
     */
    private $investissements;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="contractantInvestissement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->investissements = new ArrayCollection();
    }

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

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

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

    /**
     * @return Collection|Investissement[]
     */
    public function getInvestissements(): Collection
    {
        return $this->investissements;
    }

    public function addInvestissement(Investissement $investissement): self
    {
        if (!$this->investissements->contains($investissement)) {
            $this->investissements[] = $investissement;
            $investissement->setContractantInvestissement($this);
        }

        return $this;
    }

    public function removeInvestissement(Investissement $investissement): self
    {
        if ($this->investissements->removeElement($investissement)) {
            // set the owning side to null (unless already changed)
            if ($investissement->getContractantInvestissement() === $this) {
                $investissement->setContractantInvestissement(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    
   
}
