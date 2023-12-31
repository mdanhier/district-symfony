<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PlatRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PlatRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
class Plat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['read'])]
    private ?string $libelle = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read', 'write'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    #[Groups(['read', 'write'])]
    private ?string $prix = null;

    #[ORM\Column(length: 50)]
    #[Groups(['read', 'write'])]
    private ?string $image = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?bool $active = null;

    #[ORM\OneToMany(mappedBy: 'plat', targetEntity: Detail::class)]
    private Collection $details;

    #[ORM\ManyToOne(inversedBy: 'plats')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read', 'write'])]
    private ?Categorie $categorie = null;

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

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

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

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

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, Detail>
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): static
    {
        if (!$this->details->contains($detail)) {
            $this->details->add($detail);
            $detail->setPlat($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): static
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getPlat() === $this) {
                $detail->setPlat(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
