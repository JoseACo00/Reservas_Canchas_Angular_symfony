<?php

namespace App\Controller;

use App\Entity\Arbitro;
use App\Entity\Partido;
use App\Entity\Rol;
use App\Form\ArbitroType;
use App\Repository\ArbitroRepository;
use App\Repository\ReservaRepository;
use App\Repository\PartidoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @property ArbitroRepository $ArbitroRepository
 */
class ArbitroController extends AbstractController
{

    private $ArbitroRepository;
    private $PartidoRepository;
    private $ReservaRepository;
    public function __construct(ArbitroRepository $ArbitroRepository, PartidoRepository $PartidoRepository, ReservaRepository $ReservaRepository,
    PartidoRepository $partidoRepository)
    {
        $this->ArbitroRepository = $ArbitroRepository;
        $this->PartidoRepository = $PartidoRepository;
        $this->ReservaRepository = $ReservaRepository;
    }

    /**
     * Registrar un nuevo árbitro.
     *
     * @Route("/registroArbitro", name="add_arbitro", methods={"POST"})
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    #[Route('/registroArbitro', name: 'add_arbitro', methods: ['POST'])]
    public function registrarArbitro(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $Arbitro = new Arbitro();

        $arbitroForm = $this->createForm(ArbitroType::class, $Arbitro);

        $arbitroForm->submit($data);

        if(!$arbitroForm->isValid()){
            return $arbitroForm;
        }

        $exisiArbitroEmail= $em->getRepository(Arbitro::class)->findOneBy(['email'=>$Arbitro->getEmail()]);
        if($exisiArbitroEmail){
            return  new JsonResponse(['error' => 'El email pertenece a otro arbitro'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $existArbitroPhone= $em->getRepository(Arbitro::class)->findOneBy(['phone'=>$Arbitro->getEmail()]);
        if($existArbitroPhone){
            return  new JsonResponse(['error', 'El número ya pertenece a otro arbitro'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $rolArbitro= $em->getRepository(Rol::class)->find(3);

        if(!$rolArbitro){
            return  new JsonResponse(['error' => 'El rol de'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $Arbitro->setRol($rolArbitro);

        $hashedPassword= password_hash($Arbitro->getPassword(), PASSWORD_DEFAULT);
        $Arbitro->setPassword($hashedPassword);
        $Arbitro->setCreatedAt(new \DateTime('now'));

        $em->persist($Arbitro);
        $em->flush();

        return new JsonResponse(['status' => 'Arbitro registrado'], JsonResponse::HTTP_CREATED);

    }


    /**
     * Obtener todos los árbitros.
     *
     * @Route("/cargarArbitros", name="cargarArbitros", methods={"GET"})
     *
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    //OBTENER ARBTIROS
    #[Route('/cargarArbitros', name: 'cargarArbitros', methods: ['GET'])]
    public function cargarArbitros(EntityManagerInterface $em)
    {

        $arbitro= $em->getRepository(Arbitro::class)->findAll();

        if(!$arbitro){
            return new JsonResponse(['error' => 'No existen arbitros'], JsonResponse::HTTP_NOT_FOUND);
        }

        $ObtenerArbitros=[];
        foreach ($arbitro as $arbitro){
            $ObtenerArbitros [] = [
                'id' => $arbitro->getId(),
                'name' => $arbitro->getName(),
                'surname1' => $arbitro->getSurname1(),
                'email' => $arbitro->getEmail(),
                'phone' => $arbitro->getPhone(),
            ];
        }

        return new JsonResponse($ObtenerArbitros);
    }


     //Modificar Experencias o disponibilidad
    /**
     * Actualizar el estado de un árbitro en un partido.
     *
     * @Route("/partido/{partido_id}/estado_arbitro", name="actualizar_estado_arbitro", methods={"PUT"})
     *
     * @param int $partido_id
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    #[Route('/arbitro/{arbitro_id}/edit', name: 'ModificarUsuario', methods: ['PUT'])]
    public function  editarArbitro(EntityManagerInterface $em, $arbitro_id, Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(),true);

        $arbitro = $em->getRepository(Arbitro::class)->find($arbitro_id);

        if (!$arbitro) {
            return new JsonResponse(['error' => 'El arbitro no existe'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Actualizar la experiencia si está presente en los datos
        if (isset($data['experiences'])) {
            $arbitro->setExperiences($data['experiences']);
        }

        // Actualizar la disponibilidad si está presente en los datos
        if (isset($data['disponibilidad'])) {
            $arbitro->setDisponibilidad($data['disponibilidad']);
        }

        $em->persist($arbitro);
        $em->flush();

        return new JsonResponse(['success' => 'Arbitro actualizado correctamente'], JsonResponse::HTTP_OK);

    }

    //Poder rechazar asignaciones del admin
    #[Route('/partido/{partido_id}/estado_arbitro', name :'actualizar_estado_arbitro', methods: ['PUT'])]

    public function actualizarEstadoArbitro($partido_id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $nuevoEstado = $data['estado_arbitro'] ?? null;

        if (!in_array($nuevoEstado, ['Pendiente', 'Aceptado', 'Denegado'])) {
            return new JsonResponse(['error' => 'Estado inválido'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $partido = $em->getRepository(Partido::class)->find($partido_id);
        if (!$partido) {
            return new JsonResponse(['error' => 'Partido no encontrado'], JsonResponse::HTTP_NOT_FOUND);
        }

        $partido->setEstadoArbitro($nuevoEstado);
        $partido->setModifiedAt(new \DateTime('now'));

        $em->flush();

        return new JsonResponse(['success' => 'Estado del árbitro actualizado correctamente'], JsonResponse::HTTP_OK);
    }

    /**
     * Obtener los partidos asignados a un árbitro.
     *
     * @Route("/arbitro/{arbitro_id}/partidos", name="MatchArbitros", methods={"GET"})
     *
     * @param int $arbitro_id
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    #[Route('/arbitro/{arbitro_id}/partidos', name:'MatchArbitros', methods:['GET'])]
    public function obtenerMatchDeArbitros($arbitro_id, EntityManagerInterface $em): JsonResponse
    {
        $partidos = $em->getRepository(Partido::class)->findBy(['arbitro' => $arbitro_id]);

        if (!$partidos) {
            return new JsonResponse(['error' => 'No se encontraron partidos para este árbitro'], JsonResponse::HTTP_NOT_FOUND);
        }

        $partidosData = [];
        foreach ($partidos as $partido) {
            $partidosData[] = [
                'id' => $partido->getId(),
                'usuario' => [
                    'id' => $partido->getUsuario()->getId(),
                    'nombre' => $partido->getUsuario()->getName(),
                ],
                'cancha' => [
                    'id' => $partido->getCancha()->getId(),
                    'nombre' => $partido->getCancha()->getNombre(),
                    'direccion' => $partido->getCancha()->getDireccion(),
                ],
                'reserva' => [
                    'fecha_reserva' => $partido->getReserva()->getFechaReserva()->format('Y-m-d'),
                    'hora_reserva' => $partido->getReserva()->getHoraReserva(),
                    'hora_fin' => $partido->getReserva()->getHoraFin(),
                ],
                'estado_arbitro' => $partido->getEstadoArbitro(),
            ];
        }

        return new JsonResponse($partidosData, JsonResponse::HTTP_OK);
    }


    /**
     * Obtener información de un árbitro por ID.
     *
     * @Route("/arbitro/{arbitro_id}", name="obtener_arbitro", methods={"GET"})
     *
     * @param int $arbitro_id
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    #[Route('/arbitro/{arbitro_id}', name:'obtener_arbitro', methods:['GET'])]
    public function obtenerArbitro($arbitro_id, EntityManagerInterface $em): JsonResponse
    {
        $arbitro = $em->getRepository(Arbitro::class)->find($arbitro_id);

        if (!$arbitro) {
            return new JsonResponse(['error' => 'El árbitro no existe'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $arbitro->getId(),
            'name' => $arbitro->getName(),
            'surname1' => $arbitro->getSurname1(),
            'experiences' => $arbitro->getExperiences(),
            'disponibilidad' => $arbitro->getDisponibilidad(),
        ];

        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }

}
