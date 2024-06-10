<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Arbitro;
use App\Entity\Cancha;
use App\Entity\Partido;
use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Form\CanchaType;
use App\Repository\AdminRepository;
use App\Repository\CanchaRepository;
use App\Repository\PartidoRepository;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


class AdminController extends AbstractController
{

    private $CanchaRepository;
    private $AdminRepository;

    private  $PartidoRepository;

    private $UserRepository;
    private $serializer;
    public function   __construct(AdminRepository $AdminRepository, CanchaRepository $CanchaRepository,
                                  PartidoRepository $partidoRepository,UsuarioRepository $usuarioRepository,SerializerInterface $serializer)
    {
        $this->AdminRepository = $AdminRepository;
        $this->CanchaRepository = $CanchaRepository;
        $this->PartidoRepository = $partidoRepository;
        $this->UserRepository= $usuarioRepository;
        $this->serializer = $serializer;
    }

    //CREACION DE ADMIN
    #[Route('/registrarCancha', name: 'registrarCancha', methods: ['POST'])]
    public function crearCancha(Request $request, EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $data = json_decode($request->getContent(), true);

        $cancha = new Cancha();

        // Eliminar la protección CSRF
        $canchaForm = $this->createForm(CanchaType::class, $cancha, ['csrf_protection' => false]);
        $canchaForm->submit($data);

        if ($canchaForm->isValid()) {
            $cancha = $canchaForm->getData();

            if (isset($data['imagen'])) {
                $imageUrl = $data['imagen'];
                $imageContents = file_get_contents($imageUrl);
                if ($imageContents) {
                    $originalFilename = pathinfo($imageUrl, PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.jpg'; // o la extensión apropiada

                    $imageDirectory = $this->getParameter('kernel.project_dir') . '/public/imagesCanchas';
                    if (!file_exists($imageDirectory)) {
                        mkdir($imageDirectory, 0777, true);
                    }

                    $imagePath = $imageDirectory . '/' . $newFilename;
                    file_put_contents($imagePath, $imageContents);
                    $cancha->setImagen($newFilename);
                } else {
                    return new JsonResponse(['error' => 'No se pudo descargar la imagen'], JsonResponse::HTTP_BAD_REQUEST);
                }
            }

            $cancha->setCreatedAt(new \DateTime('now'));

            $em->persist($cancha);
            $em->flush();

            return new JsonResponse(['success' => 'Cancha created successfully.'], JsonResponse::HTTP_CREATED);
        } else {
            $errors = [];
            foreach ($canchaForm->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }
            return new JsonResponse(['error' => $errors], JsonResponse::HTTP_BAD_REQUEST);
        }
    }


    //EDIT DE CANCHA
    #[Route('/cancha/{cancha_id}/edit', name: 'actualizarCancha', methods: ['PUT'])]
    public function editarCancha(Request $request, $cancha_id, EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $data = json_decode($request->getContent(), true);
        $cancha = $em->getRepository(Cancha::class)->find($cancha_id);

        if (!$cancha) {
            return new JsonResponse(['error' => 'La cancha id no fue encontrada'], JsonResponse::HTTP_NOT_FOUND);
        }

        $canchaForm = $this->createForm(CanchaType::class, $cancha, ['csrf_protection' => false]);
        $canchaForm->submit($data);

        if ($canchaForm->isValid()) {
            $cancha = $canchaForm->getData();

            if (isset($data['imagen'])) {
                $imageUrl = $data['imagen'];
                $imageContents = file_get_contents($imageUrl);
                if ($imageContents) {
                    $originalFilename = pathinfo($imageUrl, PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.jpg'; // o la extensión apropiada

                    $imageDirectory = $this->getParameter('image_directory');
                    if (!file_exists($imageDirectory)) {
                        mkdir($imageDirectory, 0777, true);
                    }

                    $imagePath = $imageDirectory . '/' . $newFilename;
                    file_put_contents($imagePath, $imageContents);
                    $cancha->setImagen($newFilename);
                } else {
                    return new JsonResponse(['error' => 'No se pudo descargar la imagen'], JsonResponse::HTTP_BAD_REQUEST);
                }
            }

            $cancha->setModifiedAt(new \DateTime('now'));

            $em->persist($cancha);
            $em->flush();

            return new JsonResponse(['success' => 'Cancha actualizada correctamente', 'cancha' => $cancha]);
        } else {
            $errors = [];
            foreach ($canchaForm->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }
            return new JsonResponse(['error' => $errors], JsonResponse::HTTP_BAD_REQUEST);
        }
    }



    // DELETE DE CANCHA
    #[Route('/Cancha/{cancha_id}/delete', name: 'borrarCancha', methods: ['DELETE'])]
    public function eliminarCancha(Request $request, $cancha_id, EntityManagerInterface $em)
    {
        $cancha = $this->CanchaRepository->find($cancha_id);

        if (!$cancha) {
            return new JsonResponse(['error' => 'La cancha no existe'], JsonResponse::HTTP_NOT_FOUND);
        }

        if ($cancha->getDeletedAt() !== null) {
            return new JsonResponse(['error' => 'La cancha ya fue eleminada'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $cancha->setDeletedAt(new \DateTime('now'));

        $em->persist($cancha);
        $em->flush();

        return new JsonResponse(['message' => 'La cancha con el nombre: ' . $cancha->getNombre() . ' fue borrada'], JsonResponse::HTTP_OK);
    }



    //EDITAR RESERVA
    #[Route('/partido/{partido_id}/asignarArbitro', name: 'AsignarArbitro', methods: ['PUT'])]
    public function asignarArbitro(Request $request, $partido_id, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $partido = $em->getRepository(Partido::class)->find($partido_id);
        $arbitro = $em->getRepository(Arbitro::class)->find($data['arbitro_id']);

        if (!$partido) {
            return new JsonResponse(['message' => 'El partido no existe'], JsonResponse::HTTP_NOT_FOUND);
        }

        if (!$arbitro) {
            return new JsonResponse(['message' => 'El árbitro no existe'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Obtener los detalles de la reserva asociada al partido
        $reserva = $partido->getReserva();
        $fechaReserva = $reserva->getFechaReserva()->format('Y-m-d');
        $horaReserva = $reserva->getHoraReserva();
        $horaFin = $reserva->getHoraFin();

        // Verificar si el árbitro ya está asignado a otro partido en la misma fecha y hora
        $conflicto = $em->getRepository(Partido::class)->createQueryBuilder('p')
            ->join('p.reserva', 'r')
            ->where('p.arbitro = :arbitro')
            ->andWhere('r.fechaReserva = :fecha')
            ->andWhere('(:horaInicio < r.hora_fin AND :horaFin > r.hora_reserva)')
            ->setParameter('arbitro', $arbitro)
            ->setParameter('fecha', $fechaReserva)
            ->setParameter('horaInicio', $horaReserva)
            ->setParameter('horaFin', $horaFin)
            ->getQuery()
            ->getOneOrNullResult();

        if ($conflicto) {
            return new JsonResponse(['message' => 'El árbitro ya está asignado a otro partido en la misma fecha y hora'], JsonResponse::HTTP_CONFLICT);
        }

        // Asignar el árbitro al partido
        $partido->setArbitro($arbitro);
        $em->flush();

        return new JsonResponse(['success' => 'Árbitro asignado correctamente'], JsonResponse::HTTP_OK);
    }


    //CAMBIA EL ESTADO DE LA RESERVA UNA VEZ ESTE EL PAGO REALIZADO
    #[Route('/partido/{id}/estado', name: 'actualizar_estado_partido', methods: ['PUT'])]
    public function actualizarEstadoPartido($id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $nuevoEstado = $data['estado_reserva'] ?? null;

        if (!in_array($nuevoEstado, ['Pendiente', 'Aceptado', 'Denegado'])) {
            return new JsonResponse(['error' => 'Estado inválido'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $partido = $em->getRepository(Partido::class)->find($id);
        if (!$partido) {
            return new JsonResponse(['error' => 'Partido no encontrado'], JsonResponse::HTTP_NOT_FOUND);
        }

        $partido->setEstadoReserva($nuevoEstado);
        $partido->setModifiedAt(new \DateTime('now'));

        $em->flush();

        return new JsonResponse(['success' => 'Estado del partido actualizado correctamente'], JsonResponse::HTTP_OK);
    }

    #[Route('/partido/{partido_id}/detalles', name: 'detalles_partido', methods: ['GET'])]
    public function obtenerDetallesPartido($partido_id, EntityManagerInterface $em): JsonResponse
    {
        $partido = $em->getRepository(Partido::class)->find($partido_id);

        if (!$partido) {
            return new JsonResponse(['error' => 'Partido no encontrado'], JsonResponse::HTTP_NOT_FOUND);
        }

        $usuario = $partido->getUsuario();
        $arbitro = $partido->getArbitro();
        $cancha = $partido->getCancha();
        $reserva = $partido->getReserva();

        $detallesPartido = [
            'id' => $partido->getId(),
            'usuario' => [
                'nombre' => $usuario->getName(),
                'correo' => $usuario->getEmail(),
            ],
            'arbitro' => $arbitro ? $arbitro->getName() : 'No asignado',
            'cancha' => [
                'nombre' => $cancha->getNombre(),
                'direccion' => $cancha->getDireccion(),
            ],
            'reserva' => [
                'fecha' => $reserva->getFechaReserva()->format('Y-m-d'),
                'hora_inicio' => $reserva->getHoraReserva(),
                'hora_fin' => $reserva->getHoraFin(),
            ],
            'estado' => $partido->getEstadoReserva(),
        ];

        return new JsonResponse($detallesPartido);
    }




}
