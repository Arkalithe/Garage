<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['voiture:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\Positive]
    #[Groups(['voiture:read'])]
    private ?int $prix = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\Positive]
    #[Groups(['voiture:read'])]
    private ?int $kilometrage = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Groups(['voiture:read'])]
    #[Assert\Range(min: 1886, max: 2100)]
    private ?int $anneeCirculation = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    #[Groups(['voiture:read'])]
    private ?string $modele = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    #[Groups(['voiture:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    #[Groups(['voiture:read'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 30)]
    #[Groups(['voiture:read'])]
    private ?string $numero = null;

    #[ORM\OneToMany(targetEntity: CVVoiture::class, mappedBy: 'voiture', cascade: ['persist'])]
    #[Groups(['voiture:read'])]
    private Collection $caracteristique;

    #[ORM\OneToMany(targetEntity: EVVoiture::class, mappedBy: 'voiture', cascade: ['persist'])]
    #[Groups(['voiture:read'])]
    private Collection $equipements;

    #[ORM\OneToMany(targetEntity: VoitureImage::class, mappedBy: 'voiture', cascade: ['persist'])]
    #[Groups(['voiture:read'])]
    private Collection $image;

    public function __construct()
    {
        $this->caracteristique = new ArrayCollection();
        $this->equipements = new ArrayCollection();
        $this->image = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): static
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getAnneeCirculation(): ?int
    {
        return $this->anneeCirculation;
    }

    public function setAnneeCirculation(int $anneeCirculation): static
    {
        $this->anneeCirculation = $anneeCirculation;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getCaracteristique(): Collection
    {
        return $this->caracteristique;
    }

    public function addCaracteristique(CVVoiture $cvVoiture): static
    {
        if (!$this->caracteristique->contains($cvVoiture)) {
            $this->caracteristique->add($cvVoiture);
            $cvVoiture->setVoiture($this);
        }

        return $this;
    }

    public function removeCaracteristique(CVVoiture $cvVoiture): static
    {
        if ($this->caracteristique->removeElement($cvVoiture)) {
            if ($cvVoiture->getVoiture() === $this) {
                $cvVoiture->setVoiture(null);
            }
        }

        return $this;
    }

    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(EVVoiture $evVoiture): static
    {
        if (!$this->equipements->contains($evVoiture)) {
            $this->equipements->add($evVoiture);
            $evVoiture->setVoiture($this);
        }

        return $this;
    }

    public function removeEquipement(EVVoiture $evVoiture): static
    {
        if ($this->equipements->removeElement($evVoiture)) {
            if ($evVoiture->getVoiture() === $this) {
                $evVoiture->setVoiture(null);
            }
        }

        return $this;
    }

    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(VoitureImage $image): static
    {
        if (!$this->image->contains($image)) {
            $this->image->add($image);
            $image->setVoiture($this);
        }

        return $this;
    }

    public function removeImage(VoitureImage $image): static
    {
        if ($this->image->removeElement($image)) {
            if ($image->getVoiture() === $this) {
                $image->setVoiture(null);
            }
        }

        return $this;
    }
}
