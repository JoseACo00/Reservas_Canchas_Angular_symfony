<?php

namespace App\Controller;

use App\Entity\Cancha;
use App\Repository\CanchaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CanchaController extends AbstractController
{
    private  $CanchaRepository;
    public  function __construct(EntityManagerInterface $manager, CanchaRepository $CanchaRepository)
    {
        $this->CanchaRepository = $CanchaRepository;
    }
    //RUTA PARA COGER DATOS DE LA BASSE DE DATOS
    #[Route('/cargarCanchas', name: 'CargarCanchas', methods: ['GET'])]
    public function obtenereCanchas(EntityManagerInterface $em)
    {
        $qb = $em->createQueryBuilder();

        $qb->select('c')
            ->from(Cancha::class, 'c')
            ->where('c.deleted_at IS NULL');

        $canchas = $qb->getQuery()->getResult();

        if (!$canchas) {
            return new JsonResponse(['Error' => 'No existe datos en la cancha'], JsonResponse::HTTP_NOT_FOUND);
        }

        $tablaCancha = [];
        foreach ($canchas as $cancha) {
            $tablaCancha[] = [
                'id' => $cancha->getId(),
                'nombre' => $cancha->getNombre(),
                'localidad' => $cancha->getLocalidad(),
                'direccion' => $cancha->getDireccion(),
                'precio' => $cancha->getPrecio(),
                'imagen' => $cancha->getImagen(),
                'disponibilidad' => $cancha->getDisponibilidad(),
            ];
        }

        return new JsonResponse($tablaCancha);
    }



    //Obterner las canchas de de un determinado id
    #[Route('/cancha/{cancha_id}', name: 'obtener_cancha', methods: ['GET'])]
    public function obtenerCancha($cancha_id, EntityManagerInterface $em)
    {
        $cancha = $em->getRepository(Cancha::class)->find($cancha_id);

        if (!$cancha) {
            return new JsonResponse(['error' => 'Cancha no encontrada'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $cancha->getId(),
            'nombre' => $cancha->getNombre(),
            'localidad' => $cancha->getLocalidad(),
            'direccion' => $cancha->getDireccion(),
            'precio' => $cancha->getPrecio(),
            'imagen' => $cancha->getImagen(),
            'disponibilidad' => $cancha->getDisponibilidad()
        ]);
    }

}
