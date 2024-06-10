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
            $tablaPartidos[] = [
                'id' => $partido->getId(),
                'nombre_Usuario' => $partido->getUsuario()->getName(),
                'email_usuario' => $partido->getUsuario()->getEmail(),
                'arbitro_nombre' => $partido->getArbitro() ? $partido->getArbitro()->getName() : null,
                'cancha_nombre' => $partido->getCancha()->getNombre(),
                'cancha_direccion' => $partido->getCancha()->getDireccion(),
                'reserva_fecha' => $partido->getReserva()->getFechaReserva(),
                'hora_reserva' => $partido->getReserva()->getHoraReserva(),
                'hora_fin' => $partido->getReserva()->getHoraFin(),
                'opcion_arbitro' => $partido->getReserva()->getArbitroOpcion(),
                'estadoReserva' => $partido->getEstadoReserva()
            ];
        }

        return new JsonResponse($tablaPartidos);

    }


}
