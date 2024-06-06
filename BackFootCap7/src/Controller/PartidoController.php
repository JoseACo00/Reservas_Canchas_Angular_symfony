<?php

namespace App\Controller;

use App\Repository\PartidoRepository;
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


}
