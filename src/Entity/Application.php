<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ApplicationRepository::class)
 * @ApiResource(
 *     collectionOperations={"post"},
 *     itemOperations={"get"}
 * )
 */
class Application
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
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Amelioration::class, mappedBy="application", cascade={"persist"}))
     */
    private $ameliorations;

    /**
     * @ORM\OneToMany(targetEntity=ApplicationImage::class, mappedBy="application", orphanRemoval=true)
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=ApplicationFichier::class, mappedBy="application", orphanRemoval=true)
     */
    private $fichiers;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombre_telechargement;

    public function __construct()
    {
        $this->ameliorations = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->fichiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Amelioration>
     */
    public function getAmeliorations(): Collection
    {
        return $this->ameliorations;
    }

    public function addAmelioration(Amelioration $amelioration): self
    {
        if (!$this->ameliorations->contains($amelioration)) {
            $this->ameliorations[] = $amelioration;
            $amelioration->setApplication($this);
        }

        return $this;
    }

    public function removeAmelioration(Amelioration $amelioration): self
    {
        if ($this->ameliorations->removeElement($amelioration)) {
            // set the owning side to null (unless already changed)
            if ($amelioration->getApplication() === $this) {
                $amelioration->setApplication(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ApplicationImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ApplicationImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setApplication($this);
        }

        return $this;
    }

    public function removeImage(ApplicationImage $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getApplication() === $this) {
                $image->setApplication(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ApplicationFichier>
     */
    public function getFichiers(): Collection
    {
        return $this->fichiers;
    }

    public function addFichier(ApplicationFichier $fichier): self
    {
        if (!$this->fichiers->contains($fichier)) {
            $this->fichiers[] = $fichier;
            $fichier->setApplication($this);
        }

        return $this;
    }

    public function removeFichier(ApplicationFichier $fichier): self
    {
        if ($this->fichiers->removeElement($fichier)) {
            // set the owning side to null (unless already changed)
            if ($fichier->getApplication() === $this) {
                $fichier->setApplication(null);
            }
        }

        return $this;
    }

    public function getNombreTelechargement(): ?int
    {
        return $this->nombre_telechargement;
    }

    public function setNombreTelechargement(int $nombre_telechargement): self
    {
        $this->nombre_telechargement = $nombre_telechargement;

        return $this;
    }
}
