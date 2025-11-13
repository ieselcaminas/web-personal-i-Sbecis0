<?php

namespace App\Entity;

use App\Repository\SkinRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SkinRepository::class)]
class Skin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Weapon::class, inversedBy: 'skins')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Weapon $weapon = null;



    #[ORM\Column(length: 255)]
    private ?string $rarity = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(name: "wear_float")]
    private ?float $float = null;

    #[ORM\Column]
    private ?int $pattern = null;

    #[ORM\Column]
    private ?bool $stattrak = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    /**
     * @var File|null
     */
    #[Assert\Image(
        maxSize: '5M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
        mimeTypesMessage: 'Por favor sube una imagen válida (JPG, PNG, WEBP)'
    )]
    private ?File $imageFile = null;


    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getWeapon(): ?Weapon
    {
        return $this->weapon;
    }

    public function setWeapon(?Weapon $weapon): static
    {
        $this->weapon = $weapon;

        return $this;
    }

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function setRarity(string $rarity): static
    {
        $this->rarity = $rarity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getFloat(): ?float
    {
        return $this->float;
    }

    public function setFloat(float $float): static
    {
        $this->float = $float;

        return $this;
    }

    public function getPattern(): ?int
    {
        return $this->pattern;
    }

    public function setPattern(int $pattern): static
    {
        $this->pattern = $pattern;

        return $this;
    }

    public function isStattrak(): ?bool
    {
        return $this->stattrak;
    }

    public function setStattrak(bool $stattrak): static
    {
        $this->stattrak = $stattrak;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
