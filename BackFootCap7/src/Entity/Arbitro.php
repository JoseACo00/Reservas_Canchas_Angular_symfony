<?php

namespace App\Entity;

use App\Repository\ArbitroRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArbitroRepository::class)]
class Arbitro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $surname1 = null;

    #[ORM\Column(length: 255)]
    private ?string $surname2 = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?int $age = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $experiences = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?int $created_by = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modified_at = null;

    #[ORM\Column(nullable: true)]
    private ?int $modified_by = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deleted_at = null;

    #[ORM\Column(nullable: true)]
    private ?int $deleted_by = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUsername1(): ?string
    {
        return $this->username1;
    }

    public function setUsername1(string $username1): static
    {
        $this->username1 = $username1;

        return $this;
    }

    public function getUsername2(): ?string
    {
        return $this->username2;
    }

    public function setUsername2(string $username2): static
    {
        $this->username2 = $username2;

        return $this;
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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getExperiences(): ?string
    {
        return $this->experiences;
    }

    public function setExperiences(string $experiences): static
    {
        $this->experiences = $experiences;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCreatedBy(): ?int
    {
        return $this->created_by;
    }

    public function setCreatedBy(int $created_by): static
    {
        $this->created_by = $created_by;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modified_at;
    }

    public function setModifiedAt(\DateTimeInterface $modified_at): static
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    public function getModifiedBy(): ?int
    {
        return $this->modified_by;
    }

    public function setModifiedBy(int $modified_by): static
    {
        $this->modified_by = $modified_by;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(\DateTimeInterface $deleted_at): static
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getDeletedBy(): ?int
    {
        return $this->deleted_by;
    }

    public function setDeletedBy(int $deleted_by): static
    {
        $this->deleted_by = $deleted_by;

        return $this;
    }
}
