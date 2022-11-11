<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Email(
     *  message = "The email '{{ value }}' is not a valid email;"
     * )
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @Assert\Valid
     * @ORM\OneToOne(targetEntity=Personne::class, cascade={"persist", "remove"})
     */
    private $personne;

    /**
     * @ORM\OneToOne(targetEntity=Cv::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $cv;

    /**
     * @ORM\OneToMany(targetEntity=Social::class, mappedBy="user", cascade={"persist"})
     */
    private $socials;

        /**
     * @Assert\Valid
     * @ORM\OneToOne(targetEntity=Adresse::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private $adresse;
        /**
     * 
     * @ORM\OneToMany(targetEntity=Phone::class, mappedBy="user")
     */
    private $phones;

    /**
     * @ORM\OneToMany(targetEntity=Depense::class, mappedBy="user")
     */
    private $depense;

    /**
     * @ORM\OneToMany(targetEntity=ClientRDV::class, mappedBy="user",cascade={"remove"})
     */
    private $clientRDVs;

    /**
     * @ORM\OneToMany(targetEntity=Module::class, mappedBy="user", cascade={"remove"})
     */
    private $module;

    /**
     * @ORM\OneToMany(targetEntity=CentreFormation::class, mappedBy="user",cascade={"remove"})
     */
    private $centreFormation;

    /**
     * @ORM\OneToMany(targetEntity=Projet::class, mappedBy="user",cascade={"remove"})
     */
    private $projet;

    /**
     * @ORM\OneToMany(targetEntity=ContractantInvestissement::class, mappedBy="user")
     */
    private $contractantInvestissement; 

    public function __construct()
    {
        $this->phones = new ArrayCollection();
        $this->socials = new ArrayCollection();
        $this->depense = new ArrayCollection();
        $this->clientRDVs = new ArrayCollection();
        $this->module = new ArrayCollection();
        $this->centreFormation = new ArrayCollection();
        $this->projet = new ArrayCollection();
        $this->contractantInvestissement = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        // $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): self
    {
        $this->personne = $personne;

        return $this;
    }

    public function getCv(): ?Cv
    {
        return $this->cv;
    }

    public function setCv(Cv $cv): self
    {
        // set the owning side of the relation if necessary
        if ($cv->getUser() !== $this) {
            $cv->setUser($this);
        }

        $this->cv = $cv;

        return $this;
    }

    /**
     * @return Collection|Social[]
     */
    public function getSocials(): Collection
    {
        return $this->socials;
    }

    public function addSocial(Social $social): self
    {
        if (!$this->socials->contains($social)) {
            $this->socials[] = $social;
            $social->setUser($this);
        }

        return $this;
    }

    public function removeSocial(Social $social): self
    {
        if ($this->socials->removeElement($social)) {
            // set the owning side to null (unless already changed)
            if ($social->getUser() === $this) {
                $social->setUser(null);
            }
        }

        return $this;
    }
    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }
     /**
     * @return Collection|Phone[]
     */
    public function getPhones(): Collection
    {
        return $this->phones;
    }

    public function addPhone(Phone $phone): self
    {
        if (!$this->phones->contains($phone)) {
            $this->phones[] = $phone;
            $phone->setUser($this);
        }

        return $this;
    }

    public function removePhone(Phone $phone): self
    {
        if ($this->phones->removeElement($phone)) {
            // set the owning side to null (unless already changed)
            if ($phone->getUser() === $this) {
                $phone->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Depense[]
     */
    public function getDepense(): Collection
    {
        return $this->depense;
    }

    public function addDepense(Depense $depense): self
    {
        if (!$this->depense->contains($depense)) {
            $this->depense[] = $depense;
            $depense->setUser($this);
        }

        return $this;
    }

    public function removeDepense(Depense $depense): self
    {
        if ($this->depense->removeElement($depense)) {
            // set the owning side to null (unless already changed)
            if ($depense->getUser() === $this) {
                $depense->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ClientRDV[]
     */
    public function getClientRDVs(): Collection
    {
        return $this->clientRDVs;
    }

    public function addClientRDV(ClientRDV $clientRDV): self
    {
        if (!$this->clientRDVs->contains($clientRDV)) {
            $this->clientRDVs[] = $clientRDV;
            $clientRDV->setUser($this);
        }

        return $this;
    }

    public function removeClientRDV(ClientRDV $clientRDV): self
    {
        if ($this->clientRDVs->removeElement($clientRDV)) {
            // set the owning side to null (unless already changed)
            if ($clientRDV->getUser() === $this) {
                $clientRDV->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModule(): Collection
    {
        return $this->module;
    }

    public function addModule(Module $module): self
    {
        if (!$this->module->contains($module)) {
            $this->module[] = $module;
            $module->setUser($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->module->removeElement($module)) {
            // set the owning side to null (unless already changed)
            if ($module->getUser() === $this) {
                $module->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CentreFormation[]
     */
    public function getCentreFormation(): Collection
    {
        return $this->centreFormation;
    }

    public function addCentreFormation(CentreFormation $centreFormation): self
    {
        if (!$this->centreFormation->contains($centreFormation)) {
            $this->centreFormation[] = $centreFormation;
            $centreFormation->setUser($this);
        }

        return $this;
    }

    public function removeCentreFormation(CentreFormation $centreFormation): self
    {
        if ($this->centreFormation->removeElement($centreFormation)) {
            // set the owning side to null (unless already changed)
            if ($centreFormation->getUser() === $this) {
                $centreFormation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Projet[]
     */
    public function getProjet(): Collection
    {
        return $this->projet;
    }

    public function addProjet(Projet $projet): self
    {
        if (!$this->projet->contains($projet)) {
            $this->projet[] = $projet;
            $projet->setUser($this);
        }

        return $this;
    }

    public function removeProjet(Projet $projet): self
    {
        if ($this->projet->removeElement($projet)) {
            // set the owning side to null (unless already changed)
            if ($projet->getUser() === $this) {
                $projet->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ContractantInvestissement[]
     */
    public function getContractantInvestissement(): Collection
    {
        return $this->contractantInvestissement;
    }

    public function addContractantInvestissement(ContractantInvestissement $contractantInvestissement): self
    {
        if (!$this->contractantInvestissement->contains($contractantInvestissement)) {
            $this->contractantInvestissement[] = $contractantInvestissement;
            $contractantInvestissement->setUser($this);
        }

        return $this;
    }

    public function removeContractantInvestissement(ContractantInvestissement $contractantInvestissement): self
    {
        if ($this->contractantInvestissement->removeElement($contractantInvestissement)) {
            // set the owning side to null (unless already changed)
            if ($contractantInvestissement->getUser() === $this) {
                $contractantInvestissement->setUser(null);
            }
        }

        return $this;
    }

}
