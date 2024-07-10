<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
#[ApiResource]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $image_url = null;

    /**
     * @var Collection<int, VoitureImage>
     */
    #[ORM\ManyToMany(targetEntity: VoitureImage::class, mappedBy: 'image_url')]
    private Collection $ImageVoiture;

    public function __construct()
    {
        $this->ImageVoiture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(string $image_url): static
    {
        $this->image_url = $image_url;

        return $this;
    }

    /**
     * @return Collection<int, VoitureImage>
     */
    public function getImageVoiture(): Collection
    {
        return $this->ImageVoiture;
    }

    public function addImageVoiture(VoitureImage $imageVoiture): static
    {
        if (!$this->ImageVoiture->contains($imageVoiture)) {
            $this->ImageVoiture->add($imageVoiture);
            $imageVoiture->addImageUrl($this);
        }

        return $this;
    }

    public function removeImageVoiture(VoitureImage $imageVoiture): static
    {
        if ($this->ImageVoiture->removeElement($imageVoiture)) {
            $imageVoiture->removeImageUrl($this);
        }

        return $this;
    }
}
