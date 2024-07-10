<?php

namespace App\Entity;

use App\Repository\EvVoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvVoitureRepository::class)]
class EvVoiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Voiture>
     */
    #[ORM\ManyToMany(targetEntity: Voiture::class, inversedBy: 'EvVoiture')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $voiture;

    /**
     * @var Collection<int, Equipement>
     */
    #[ORM\ManyToMany(targetEntity: Equipement::class, inversedBy: 'EvVoiture')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $equipement;

    public function __construct()
    {
        $this->voiture = new ArrayCollection();
        $this->equipement = new ArrayCollection();
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
     * @return Collection<int, Equipement>
     */
    public function getEquipement(): Collection
    {
        return $this->equipement;
    }

    public function addEquipement(Equipement $equipement): static
    {
        if (!$this->equipement->contains($equipement)) {
            $this->equipement->add($equipement);
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): static
    {
        $this->equipement->removeElement($equipement);

        return $this;
    }
}
