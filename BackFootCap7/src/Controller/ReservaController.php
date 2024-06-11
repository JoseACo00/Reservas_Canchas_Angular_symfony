<?php

namespace App\Controller;

use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Repository\CanchaRepository;
use App\Repository\ReservaRepository;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ReservaController extends AbstractController
{
    private  $ReservaRepository;
    private  $UsuarioRepository;

    private  $CanchaRepository;
    public  function  __construct(  ReservaRepository $ReservaRepository,   UsuarioRepository $UsuarioRepository, CanchaRepository $CanchaRepository)
    {
        $this->ReservaRepository=$ReservaRepository;
        $this->UsuarioRepository=$UsuarioRepository;
        $this->CanchaRepository=$CanchaRepository;
    }


    // Obtener todas las reservas de un usuario específico SOFT DELETE NO SE MUESTRA
    #[Route('/usuario/{usuario_id}/reservas', name: 'reservas_usuario', methods: ['GET'])]
    public function reservasDeUsuario(EntityManagerInterface $em, $usuario_id)
    {
        $qb = $em->createQueryBuilder();

        $qb->select('r')
            ->from(Reserva::class, 'r')
            ->where('r.usuario = :usuario_id')
            ->andWhere('r.deleted_at IS NULL')
            ->setParameter('usuario_id', $usuario_id);

        $reservas = $qb->getQuery()->getResult();

        if (!$reservas) {
            return new JsonResponse(['error' => 'No se encontraron reservas para este usuario'], 404);
        }
        $reservasData = [];
        foreach ($reservas as $reserva) {
            $reservasData[] = [
                'id' => $reserva->getId(),
                'fecha_reserva' => $reserva->getFechaReserva()->format('Y-m-d'),
                'hora_reserva' => $reserva->getHoraReserva(),
                'hora_fin' => $reserva->getHoraFin(),
                'arbitro_opcion' => $reserva->getArbitroOpcion(),
                'metodo_pago' => $reserva->getMetodoPago(),
                'comprobante_pago' => $reserva->getComprobantePago(),
                'cancha' => [
                    'id' => $reserva->getCancha()->getId(),
                    'nombre' => $reserva->getCancha()->getNombre()
                ]
            ];
        }

        return new JsonResponse($reservasData);
    }
}
