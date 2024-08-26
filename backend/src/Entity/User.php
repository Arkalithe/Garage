<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8, minMessage: "Le Mot de Passe doit faire au moins 8 caractère")]
    #[Assert\Regex(
        pattern: "/[a-z]/",
        message: "Le Mot de Passe doit contenire au moins une lettre minuscule",
        match: true
    )]
    #[Assert\Regex(
        pattern: "/[A-Z]/",
        message: "Le Mot de Passe doit contenire au moins une lettre majuscule",
        match: true
    )]
    #[Assert\Regex(
        pattern: "/[0-9]/",
        message: "Le Mot de Passe doit contenire au moins un chiffre",
        match: true
    )]
    #[Assert\Regex(
        pattern: "/[^a-zA-Z0-9]/",
        message: "Le Mot de Passe doit contenire au moins un caractère special",
        match: true
    )]
    #[ORM\Column(length: 1000)]
    private ?string $password = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 25)]
    private ?string $role = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function eraseCredentials()
    {
        // $this->plainPassword = null;
    }

    public function getUsername(): string
    {
        return (string)$this->email;
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }
}
