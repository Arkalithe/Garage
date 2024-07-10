<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
#[ApiResource]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column]
    private ?int $kilometrage = null;

    #[ORM\Column]
    private ?int $annee_circulation = null;

    #[ORM\Column(length: 50)]
    private ?string $modle = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 30)]
    private ?string $numero = null;

    /**
     * @var Collection<int, CvVoiture>
     */
    #[ORM\ManyToMany(targetEntity: CvVoiture::class, mappedBy: 'Voiture')]
    private Collection $cvVoiture;

    /**
     * @var Collection<int, EvVoiture>
     */
    #[ORM\ManyToMany(targetEntity: EvVoiture::class, mappedBy: 'voiture')]
    private Collection $EvVoiture;

    /**
     * @var Collection<int, VoitureImage>
     */
    #[ORM\ManyToMany(targetEntity: VoitureImage::class, mappedBy: 'voiture')]
    private Collection $ImageVoiture;

    public function __construct()
    {
        $this->cvVoiture = new ArrayCollection();
        $this->EvVoiture = new ArrayCollection();
        $this->ImageVoiture = new ArrayCollection();
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
        return $this->annee_circulation;
    }

    public function setAnneeCirculation(int $annee_circulation): static
    {
        $this->annee_circulation = $annee_circulation;

        return $this;
    }

    public function getModle(): ?string
    {
        return $this->modle;
    }

    public function setModle(string $modle): static
    {
        $this->modle = $modle;

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

    /**
     * @return Collection<int, CvVoiture>
     */
    public function getCvVoiture(): Collection
    {
        return $this->cvVoiture;
    }

    public function addCvVoiture(CvVoiture $cvVoiture): static
    {
        if (!$this->cvVoiture->contains($cvVoiture)) {
            $this->cvVoiture->add($cvVoiture);
            $cvVoiture->addVoiture($this);
        }

        return $this;
    }

    public function removeCvVoiture(CvVoiture $cvVoiture): static
    {
        if ($this->cvVoiture->removeElement($cvVoiture)) {
            $cvVoiture->removeVoiture($this);
        }

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
            $evVoiture->addVoiture($this);
        }

        return $this;
    }

    public function removeEvVoiture(EvVoiture $evVoiture): static
    {
        if ($this->EvVoiture->removeElement($evVoiture)) {
            $evVoiture->removeVoiture($this);
        }

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
            $imageVoiture->addVoiture($this);
        }

        return $this;
    }

    public function removeImageVoiture(VoitureImage $imageVoiture): static
    {
        if ($this->ImageVoiture->removeElement($imageVoiture)) {
            $imageVoiture->removeVoiture($this);
        }

        return $this;
    }
}
