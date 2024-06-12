<?php

namespace App\Controller;

use App\Entity\Partido;
use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Entity\Cancha;
use App\Repository\PartidoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class PartidoController extends AbstractController
{

    private $partidoRepository;
    public function  __construct(PartidoRepository $partidoRepository)
    {
        $this->partidoRepository = $partidoRepository;
    }

    //OBTENER LOS PARTIDOS
    #[Route('/partido/{partido_id}', name: 'partido_view', methods: ['GET'])]
    public function view($partido_id, PartidoRepository $partidoRepository): JsonResponse
    {
        $partido = $partidoRepository->find($partido_id);
        if (!$partido) {
            return new JsonResponse(['error' => 'Partido no encontrado'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $partido->getId(),
            'usuario' => $partido->getUsuario()->getId(),
            'arbitro' => $partido->getArbitro() ? $partido->getArbitro()->getId() : null,
            'cancha' => $partido->getCancha()->getId(),
            'reserva' => $partido->getReserva()->getId(),
            'estado' => $partido->getEstadoReserva(),
        ]);
    }

    //Obtner todos los partidos para admin
    #[Route('/cargarPartidos/admin', name: 'CargarPartidos', methods: ['GET'])]
    public function cargarPartidos(EntityManagerInterface $em): JsonResponse
    {
        $partidos = $em->getRepository(Partido::class)->findAll();

        $tablaPartidos = [];
        foreach ($partidos as $partido) {
            $arbitro = $partido->getArbitro();
            $tablaPartidos[] = [
                'id' => $partido->getId(),
                'nombre_Usuario' => $partido->getUsuario()->getName(),
                'email_usuario' => $partido->getUsuario()->getEmail(),
                'arbitro_nombre' => $arbitro ? $arbitro->getName() . ' ' . $arbitro->getSurname1() : null,
                'cancha_nombre' => $partido->getCancha()->getNombre(),
                'cancha_direccion' => $partido->getCancha()->getDireccion(),
                'reserva_fecha' => $partido->getReserva()->getFechaReserva()->format('Y-m-d'),
                'hora_reserva' => $partido->getReserva()->getHoraReserva(),
                'hora_fin' => $partido->getReserva()->getHoraFin(),
                'opcion_arbitro' => $partido->getReserva()->getArbitroOpcion(),
                'estadoReserva' => $partido->getEstadoReserva()
            ];
        }

        return new JsonResponse($tablaPartidos);

    }


    //ENDPOINT PARA QUE EL USUARIO PUEDA VISUALIZAR SUS PARTIDOS
    #[Route('/partidos/Usuario/{usuario_id}', name: 'CargarPartidosUsuario', methods: ['GET'])]
    public function mostrarPartidosDeUsuario(EntityManagerInterface $em, $usuario_id)
    {
        $queryBuilder = $em->getRepository(Partido::class)->createQueryBuilder('p')
            ->join('p.reserva', 'r')
            ->where('p.usuario = :usuario_id')
            ->andWhere('p.deleted_at IS NULL')
            ->andWhere('r.deleted_at IS NULL')
            ->setParameter('usuario_id', $usuario_id)
            ->getQuery();

        $partidos = $queryBuilder->getResult();

        if (!$partidos) {
            return new JsonResponse(['error' => 'No se encontraron partidos para este usuario'], 404);
        }

        $partidosData = [];
        foreach ($partidos as $partido) {
            $partidosData[] = [
                'id' => $partido->getId(),
                'nombre_usuario' => $partido->getUsuario()->getName(),
                'email_usuario' => $partido->getUsuario()->getEmail(),
                'arbitro_nombre' => $partido->getArbitro() ? $partido->getArbitro()->getName() . ' ' . $partido->getArbitro()->getSurname1() : 'No asignado',
                'cancha_nombre' => $partido->getCancha()->getNombre(),
                'cancha_direccion' => $partido->getCancha()->getDireccion(),
                'reserva_fecha' => $partido->getReserva()->getFechaReserva()->format('Y-m-d'),
                'hora_reserva' => $partido->getReserva()->getHoraReserva(),
                'hora_fin' => $partido->getReserva()->getHoraFin(),
                'opcion_arbitro' => $partido->getReserva()->getArbitroOpcion(),
                'estado_reserva' => $partido->getEstadoReserva(),
            ];
        }

        return new JsonResponse($partidosData);
    }
}
