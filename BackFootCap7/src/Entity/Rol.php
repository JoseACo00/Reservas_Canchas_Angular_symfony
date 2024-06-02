<?php

namespace App\Entity;

use App\Repository\RolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RolRepository::class)]
class Rol
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $nameRol = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameRol(): ?string
    {
        return $this->nameRol;
    }

    public function setNameRol(string $nameRol): static
    {
        $this->nameRol = $nameRol;

        return $this;
    }

}
