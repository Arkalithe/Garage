<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\HoraireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: HoraireRepository::class)]
class Horaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $day_id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heureStart = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heureFin = null;

    #[ORM\Column(length: 255)]
    private ?string $timePeriode = null;

    #[ORM\Column]
    private ?bool $isFermed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayId(): ?int
    {
        return $this->day_id;
    }

    public function setDayId(int $day_id): static
    {
        $this->day_id = $day_id;

        return $this;
    }

    public function getHeureStart(): ?\DateTimeInterface
    {
        return $this->heureStart;
    }

    public function setHeureStart(\DateTimeInterface $heureStart): static
    {
        $this->heureStart = $heureStart;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTimeInterface $heureFin): static
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getTimePeriode(): ?string
    {
        return $this->timePeriode;
    }

    public function setTimePeriode(string $timePeriode): static
    {
        $this->timePeriode = $timePeriode;

        return $this;
    }

    public function getIsFermed(): ?bool
    {
        return $this->isFermed;
    }

    public function setIsFermed(bool $isFermed): static
    {
        $this->isFermed = $isFermed;

        return $this;
    }
}
