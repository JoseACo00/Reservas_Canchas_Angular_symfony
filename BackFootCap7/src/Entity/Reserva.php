<?php

namespace App\Entity;

use App\Repository\ReservaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservaRepository::class)]
class Reserva
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Usuario::class)]
    #[ORM\JoinColumn(name: "usuario_id", referencedColumnName: "id", nullable: false)]
    private ?Usuario $usuario;

    #[ORM\ManyToOne(targetEntity: Cancha::class)]
    #[ORM\JoinColumn(name: "cancha_id", referencedColumnName: "id", nullable: false)]
    private ?Cancha $cancha;
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaReserva = null;

    #[ORM\Column(length: 40)]
    private ?string $hora_reserva = null;

    #[ORM\Column(length: 40)]
    private ?string $hora_fin = null;

    #[ORM\Column]
    private ?bool $arbitro_opcion = null;

    #[ORM\Column(length: 30)]
    private ?string $metodo_pago = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comprobante_pago = null;

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

    public function getFechaReserva(): ?\DateTimeInterface
    {
        return $this->fechaReserva;
    }

    public function setFechaReserva(\DateTimeInterface $fechaReserva): static
    {
        $this->fechaReserva = $fechaReserva;

        return $this;
    }

   public function getHoraReserva(): ?string
   {
       return $this->hora_reserva;
   }

   public function setHoraReserva(string $hora_reserva): static
   {
       $this->hora_reserva=$hora_reserva;

       return $this;

   }

   public  function getHoraFin(): ?string
   {
       return $this->hora_fin;
   }

   public  function setHoraFin(string $hora_fin): static
   {
       $this->hora_fin=$hora_fin;

       return $this;
   }

    public function getMetodoPago(): ?string
    {
        return $this->metodo_pago;
    }

    public function getArbitroOpcion(): ?bool
    {
        return $this->arbitro_opcion;
    }

    public function setArbitroOpcion(?bool $arbitro_opcion): self
    {
        $this->arbitro_opcion = $arbitro_opcion;
        return $this;
    }

    public function setMetodoPago(string $metodo_pago): static
    {
        $this->metodo_pago = $metodo_pago;

        return $this;
    }

    public function getComprobantePago(): ?string
    {
        return $this->comprobante_pago;
    }

    public function setComprobantePago(string $comprobante_pago): static
    {
        $this->comprobante_pago = $comprobante_pago;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCreatedBy(): ?int
    {
        return $this->created_by;
    }

    public function setCreatedBy(?int $created_by): static
    {
        $this->created_by = $created_by;

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

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;
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
}
