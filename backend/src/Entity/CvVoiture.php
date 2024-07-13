<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CVVoitureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: CVVoitureRepository::class)]
class CVVoiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Voiture $voiture = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?caracteristique $caracteristique = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVoiture(): ?Voiture
    {
        return $this->voiture;
    }

    public function setVoiture(?Voiture $voiture): static
    {
        $this->voiture = $voiture;

        return $this;
    }

    public function getCaracteristique(): ?caracteristique
    {
        return $this->caracteristique;
    }

    public function setCaracteristique(?caracteristique $caracteristique): static
    {
        $this->caracteristique = $caracteristique;

        return $this;
    }
}
