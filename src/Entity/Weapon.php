<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Skin;
use App\Repository\WeaponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeaponRepository::class)]
class Weapon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'weapon', targetEntity: Skin::class, cascade: ['persist', 'remove'])]
    private Collection $skins;

    public function __construct()
    {
        $this->skins = new ArrayCollection();
    }

    // Getters y setters

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return Collection<int, Skin>
     */
    public function getSkins(): Collection
    {
        return $this->skins;
    }

    public function addSkin(Skin $skin): static
    {
        if (!$this->skins->contains($skin)) {
            $this->skins->add($skin);
            $skin->setWeapon($this);
        }

        return $this;
    }

    public function removeSkin(Skin $skin): static
    {
        if ($this->skins->removeElement($skin)) {
            if ($skin->getWeapon() === $this) {
                $skin->setWeapon(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->name ?? 'Unnamed Weapon';;
    }
}
