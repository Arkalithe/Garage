<?php

namespace App\Entity;

use App\Repository\CaracteristiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: CaracteristiqueRepository::class)]
#[ApiResource]
class Caracteristique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $caracteristique = null;

    /**
     * @var Collection<int, CvVoiture>
     */
    #[ORM\ManyToMany(targetEntity: CvVoiture::class, mappedBy: 'caracteristique')]
    private Collection $CvVoiture;

    public function __construct()
    {
        $this->CvVoiture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCaracteristique(): ?string
    {
        return $this->caracteristique;
    }

    public function setCaracteristique(string $caracteristique): static
    {
        $this->caracteristique = $caracteristique;

        return $this;
    }

    /**
     * @return Collection<int, CvVoiture>
     */
    public function getCvVoiture(): Collection
    {
        return $this->CvVoiture;
    }

    public function addCvVoiture(CvVoiture $cvVoiture): static
    {
        if (!$this->CvVoiture->contains($cvVoiture)) {
            $this->CvVoiture->add($cvVoiture);
            $cvVoiture->addCaracteristique($this);
        }

        return $this;
    }

    public function removeCvVoiture(CvVoiture $cvVoiture): static
    {
        if ($this->CvVoiture->removeElement($cvVoiture)) {
            $cvVoiture->removeCaracteristique($this);
        }

        return $this;
    }
}
