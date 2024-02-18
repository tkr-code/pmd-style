<?php

namespace App\Entity;

use App\Repository\AmeliorationRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AmeliorationRepository::class)
 * @ApiResource(
 *  normalizationContext={"groups"={"amelioration:list"}},
 *  collectionOperations={"post","get"},
 *  itemOperations={"get"}
 * )
 */
class Amelioration
{
    const TYPE =[
        'Suggestions'=>'Suggestions',
        'Remarques'=>'Remarques',
        'Autres'=>'Autres'
    ];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"amelioration:list"})
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @Groups({"amelioration:list"})
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Application::class, inversedBy="ameliorations", cascade={"persist"}))
     * @ORM\JoinColumn(nullable=false)
     */
    private $application;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getApplication(): ?Application
    {
        return $this->application;
    }

    public function setApplication(?Application $application): self
    {
        $this->application = $application;

        return $this;
    }
}
