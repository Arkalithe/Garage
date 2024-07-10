<?php

namespace App\Entity;

use App\Repository\CvVoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CvVoitureRepository::class)]
class CvVoiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Voiture>
     */
    #[ORM\ManyToMany(targetEntity: Voiture::class, inversedBy: 'cvVoiture')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $Voiture;

    /**
     * @var Collection<int, Caracteristique>
     */
    #[ORM\ManyToMany(targetEntity: Caracteristique::class, inversedBy: 'CvVoiture')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $caracteristique;

    public function __construct()
    {
        $this->Voiture = new ArrayCollection();
        $this->caracteristique = new ArrayCollection();
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
        return $this->Voiture;
    }

    public function addVoiture(Voiture $voiture): static
    {
        if (!$this->Voiture->contains($voiture)) {
            $this->Voiture->add($voiture);
        }

        return $this;
    }

    public function removeVoiture(Voiture $voiture): static
    {
        $this->Voiture->removeElement($voiture);

        return $this;
    }

    /**
     * @return Collection<int, Caracteristique>
     */
    public function getCaracteristique(): Collection
    {
        return $this->caracteristique;
    }

    public function addCaracteristique(Caracteristique $caracteristique): static
    {
        if (!$this->caracteristique->contains($caracteristique)) {
            $this->caracteristique->add($caracteristique);
        }

        return $this;
    }

    public function removeCaracteristique(Caracteristique $caracteristique): static
    {
        $this->caracteristique->removeElement($caracteristique);

        return $this;
    }
}
