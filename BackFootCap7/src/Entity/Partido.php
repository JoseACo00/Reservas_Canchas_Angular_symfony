<?php

namespace App\Entity;

use App\Repository\PartidoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartidoRepository::class)]
class Partido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Usuario::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    #[ORM\ManyToOne(targetEntity: Arbitro::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Arbitro $arbitro = null;

    #[ORM\ManyToOne(targetEntity: Cancha::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cancha $cancha = null;

    #[ORM\ManyToOne(targetEntity: Reserva::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reserva $reserva = null;
    #[ORM\Column(length: 15)]
    private ?string $Estado_reserva = null;

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

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getArbitro(): ?Arbitro
    {
        return $this->arbitro;
    }

    public function setArbitro(?Arbitro $arbitro): self
    {
        $this->arbitro = $arbitro;

        return $this;
    }

    public function getCancha(): ?Cancha
    {
        return $this->cancha;
    }

    public function setCancha(?Cancha $cancha): self
    {
        $this->cancha = $cancha;

        return $this;
    }

    public function getReserva(): ?Reserva
    {
        return $this->reserva;
    }

    public function setReserva(?Reserva $reserva): self
    {
        $this->reserva = $reserva;

        return $this;
    }
    public function getEstadoReserva(): ?string
    {
        return $this->Estado_reserva;
    }

    public function setEstadoReserva(string $Estado_reserva): static
    {
        $this->Estado_reserva = $Estado_reserva;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modified_at;
    }

    public function setModifiedAt(?\DateTimeInterface $modified_at): static
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    public function getModifiedBy(): ?int
    {
        return $this->modified_by;
    }

    public function setModifiedBy(?int $modified_by): static
    {
        $this->modified_by = $modified_by;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeInterface $deleted_at): static
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getDeletedBy(): ?int
    {
        return $this->deleted_by;
    }

    public function setDeletedBy(?int $deleted_by): static
    {
        $this->deleted_by = $deleted_by;

        return $this;
    }
}
