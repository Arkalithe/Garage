<?php

namespace App\Entity;

use App\Repository\EquipementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipementRepository::class)]
class Equipement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $equipement = null;

    /**
     * @var Collection<int, EvVoiture>
     */
    #[ORM\ManyToMany(targetEntity: EvVoiture::class, mappedBy: 'equipement')]
    private Collection $EvVoiture;

    public function __construct()
    {
        $this->EvVoiture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipement(): ?string
    {
        return $this->equipement;
    }

    public function setEquipement(string $equipement): static
    {
        $this->equipement = $equipement;

        return $this;
    }

    /**
     * @return Collection<int, EvVoiture>
     */
    public function getEvVoiture(): Collection
    {
        return $this->EvVoiture;
    }

    public function addEvVoiture(EvVoiture $evVoiture): static
    {
        if (!$this->EvVoiture->contains($evVoiture)) {
            $this->EvVoiture->add($evVoiture);
            $evVoiture->addEquipement($this);
        }

        return $this;
    }

    public function removeEvVoiture(EvVoiture $evVoiture): static
    {
        if ($this->EvVoiture->removeElement($evVoiture)) {
            $evVoiture->removeEquipement($this);
        }

        return $this;
    }
}
