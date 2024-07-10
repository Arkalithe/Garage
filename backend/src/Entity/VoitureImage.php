<?php

namespace App\Entity;

use App\Repository\VoitureImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureImageRepository::class)]
class VoitureImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Voiture>
     */
    #[ORM\ManyToMany(targetEntity: Voiture::class, inversedBy: 'ImageVoiture')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $voiture;

    /**
     * @var Collection<int, Images>
     */
    #[ORM\ManyToMany(targetEntity: Images::class, inversedBy: 'ImageVoiture')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $image_url;

    public function __construct()
    {
        $this->voiture = new ArrayCollection();
        $this->image_url = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Voiture>
     */
    public function getVoiture(): Collection
    {
        return $this->voiture;
    }

    public function addVoiture(Voiture $voiture): static
    {
        if (!$this->voiture->contains($voiture)) {
            $this->voiture->add($voiture);
        }

        return $this;
    }

    public function removeVoiture(Voiture $voiture): static
    {
        $this->voiture->removeElement($voiture);

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImageUrl(): Collection
    {
        return $this->image_url;
    }

    public function addImageUrl(Images $imageUrl): static
    {
        if (!$this->image_url->contains($imageUrl)) {
            $this->image_url->add($imageUrl);
        }

        return $this;
    }

    public function removeImageUrl(Images $imageUrl): static
    {
        $this->image_url->removeElement($imageUrl);

        return $this;
    }
}
