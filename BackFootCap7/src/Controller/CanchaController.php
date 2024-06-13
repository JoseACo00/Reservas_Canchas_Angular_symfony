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

    /**
     * Obtener todas las canchas que no han sido eliminadas.
     *
     * @Route("/cargarCanchas", name="CargarCanchas", methods={"GET"})
     *
     * Este endpoint obtiene todas las canchas disponibles que no han sido eliminadas (es decir, su campo `deleted_at` es NULL).
     * Devuelve un arreglo de objetos JSON que contienen los detalles de cada cancha.
     *
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
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


    /**
     * Obtener los detalles de una cancha específica por ID.
     *
     * @Route("/cancha/{cancha_id}", name="obtener_cancha", methods={"GET"})
     *
     * Este endpoint obtiene los detalles de una cancha específica basándose en su ID.
     * Devuelve un objeto JSON que contiene los detalles de la cancha.
     *
     * @param int $cancha_id
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
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
