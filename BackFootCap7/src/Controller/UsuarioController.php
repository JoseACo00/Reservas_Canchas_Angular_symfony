<?php

namespace App\Controller;

use App\Entity\Cancha;
use App\Entity\Partido;
use App\Entity\Reserva;
use App\Entity\Rol;
use App\Entity\Usuario;
use App\Form\ReservaType;
use App\Form\UsuarioType;
use App\Repository\ArbitroRepository;
use App\Repository\CanchaRepository;
use App\Repository\ReservaRepository;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class UsuarioController extends AbstractController
{

    private $UsuarioRepository;

    private $reservaRepository;

    private  $canchaRepository;

    private  $arbitroRepository;

    private $security;
    public function __construct(UsuarioRepository $UsuarioRepository, ReservaRepository $reservaRepository, CanchaRepository $canchaRepository,
                                ArbitroRepository $arbitroRepository,Security $security)
    {
        $this->UsuarioRepository = $UsuarioRepository;
        $this->reservaRepository = $reservaRepository;
        $this->canchaRepository = $canchaRepository;
        $this->arbitroRepository = $arbitroRepository;
        $this->security = $security;

    }


    //RUTAS PARA EL USUARIO

    //ENDPOINT PARA GUARDAR EL USUARIO
    #[Route('/registrarUsuario', name: 'add_usuario', methods: ['POST'])]
    public function crearUsuario(Request $request, EntityManagerInterface $em)
    {

        // Decodificar los datos JSON de la solicitud
        $data = json_decode($request->getContent(), true);

        // Crea una nueva instancia de la entidad Usuario
        $Usuario = new Usuario();

        // Crea un formulario utilizando UsuarioForm y la nueva instancia de Usuario
        $usuarioForm = $this->createForm(UsuarioType::class, $Usuario);

        // Somete los datos al formulario
        $usuarioForm->submit($data);

        // Verificar si el formulario es válido
        if (!$usuarioForm->isValid()) {
            $usuarioForm;
        }

        // Verifica si el correo electrónico ya existe en la base de datos
        $existingEmailUser = $em->getRepository(Usuario::class)->findOneBy(['email' => $Usuario->getEmail()]);

        // Si el correo electrónico ya existe, devuelve un mensaje de error
        if ($existingEmailUser) {
            return new JsonResponse(['error' => 'El correo electrónico ya está en uso por otro usuario'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Verifica si el número de teléfono ya existe en la base de datos
        $existingPhoneUser = $em->getRepository(Usuario::class)->findOneBy(['phone' => $Usuario->getPhone()]);

        // Si el número de teléfono ya existe, devuelve un mensaje de error
        if ($existingPhoneUser) {
            return new JsonResponse(['error' => 'El número de teléfono ya está en uso por otro usuario'], JsonResponse::HTTP_BAD_REQUEST);
        }

        //ASIGNAMOS EL ROL QUE LE CORRESPONDE A ROL USUARIO

//        $rolUsuario=$this->UsuarioRepository(find->get)

        $rolUsuario = $em->getRepository(Rol::class)->find(1);
        if(!$rolUsuario){
            return  new JsonResponse(['error' => 'No se encontro el rol'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $Usuario->setRol($rolUsuario);
        // Encriptar la contraseña utilizando password_hash()
        $hashedPassword = password_hash($Usuario->getPassword(), PASSWORD_DEFAULT);
        $Usuario->setPassword($hashedPassword);

        $Usuario->setCreatedAt(new \DateTime('now'));
        // Persistir el nuevo usuario en la base de datos
        $em->persist($Usuario);
        $em->flush();

        // Mensaje de éxito y respuesta JSON
        return new JsonResponse(['status' => 'Usuario creado exitosamente'], JsonResponse::HTTP_CREATED);
    }


    // RESERVAS REALIZADAS POR EL USUARIO
    #[Route('/usuario/{usuario_id}/cancha/{cancha_id}/reservarCancha', name: 'reservar', methods: ['POST'])]
    public function reservar($usuario_id, $cancha_id, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Crear instancia de Reserva y someter al formulario para validar
        $reserva = new Reserva();

        // Validar formato de hora para asegurar que sean cadenas válidas de tiempo
        if (isset($data['hora_reserva']) && !preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/', $data['hora_reserva'])) {
            return new JsonResponse(['error' => 'Formato de hora_reserva inválido'], JsonResponse::HTTP_BAD_REQUEST);
        }
        if (isset($data['hora_fin']) && !preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/', $data['hora_fin'])) {
            return new JsonResponse(['error' => 'Formato de hora_fin inválido'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Crear el formulario y someter los datos
        $form = $this->createForm(ReservaType::class, $reserva, ['csrf_protection' => false]);
        $form->submit($data);

        if (!$form->isValid()) {
            return new JsonResponse(['error' => 'Datos inválidos', 'form_errors' => (string) $form->getErrors(true)], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Asignar usuario y cancha a la reserva
        $usuario = $em->getRepository(Usuario::class)->find($usuario_id);
        $cancha = $em->getRepository(Cancha::class)->find($cancha_id);
        if (!$usuario || !$cancha) {
            return new JsonResponse(['error' => 'Usuario o cancha no encontrados'], JsonResponse::HTTP_NOT_FOUND);
        }
        $reserva->setUsuario($usuario);
        $reserva->setCancha($cancha);

        // Comprobar conflictos de horario
        $conflictos = $em->getRepository(Reserva::class)->createQueryBuilder('r')
            ->where('r.cancha = :cancha')
            ->andWhere('r.fechaReserva = :fechaReserva')
            ->andWhere('(r.hora_reserva < :hora_fin AND r.hora_fin > :hora_reserva)')
            ->setParameter('cancha', $cancha_id)
            ->setParameter('fechaReserva', $reserva->getFechaReserva()->format('Y-m-d'))
            ->setParameter('hora_reserva', $reserva->getHoraReserva())
            ->setParameter('hora_fin', $reserva->getHoraFin())
            ->getQuery()
            ->getResult();

        if (count($conflictos) > 0) {
            return new JsonResponse(['error' => 'La cancha ya está reservada en ese horario'], JsonResponse::HTTP_CONFLICT);
        }

        // Manejar comprobante de pago si existe
        if (!empty($data['comprobante_pago'])) {
            $resultado = $this->handleFileUpload($data['comprobante_pago'], $slugger);
            if ($resultado['error']) {
                return new JsonResponse(['error' => $resultado['message']], JsonResponse::HTTP_BAD_REQUEST);
            }
            $reserva->setComprobantePago($resultado['filename']);
        }

        $reserva->setCreatedAt(new \DateTime('now'));
        // Guardar la reserva
        $em->persist($reserva);
        $em->flush();

        $em->refresh($reserva);

        // Crear partido asociado
        $partido = new Partido();
        $partido->setUsuario($usuario);
        $partido->setCancha($cancha);
        $partido->setReserva($reserva);
        $partido->setEstadoReserva('Denegado'); // Estado inicial

        // Establecer estado_arbitro basado en si se eligió un árbitro o no
        if ($reserva->getArbitroOpcion()) {
            $partido->setEstadoArbitro('Pendiente'); // Suponiendo que 'Pendiente' es un estado válido cuando se solicita un árbitro.
        } else {
            $partido->setEstadoArbitro('No requerido'); // Si no se necesita árbitro.
        }

        $em->persist($partido);
        $em->flush();

        return new JsonResponse(['success' => 'Reserva creada correctamente', 'id' => $reserva->getId()], JsonResponse::HTTP_CREATED);
    }

    private function handleFileUpload($comprobanteUrl, SluggerInterface $slugger)
    {
        // Lógica de manejo de archivo
        $comprobanteContents = @file_get_contents($comprobanteUrl);
        if (!$comprobanteContents) {
            return ['error' => true, 'message' => 'No se pudo descargar el comprobante de pago'];
        }
        $originalFilename = pathinfo($comprobanteUrl, PATHINFO_FILENAME);
        $extension = pathinfo($comprobanteUrl, PATHINFO_EXTENSION);
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $extension;

        $comprobanteDirectory = $this->getParameter('kernel.project_dir') . '/public/comprobantes';
        if (!file_exists($comprobanteDirectory)) {
            mkdir($comprobanteDirectory, 0777, true);
        }
        file_put_contents($comprobanteDirectory . '/' . $newFilename, $comprobanteContents);
        return ['error' => false, 'filename' => $newFilename];
    }



    //EDITAR RESERVAS
    #[Route('/usuario/{usuario_id}/reserva/{reserva_id}/cancha/{cancha_id}/editar', name: 'editar_reserva', methods: ['PUT'])]
    public function editarReserva($usuario_id, $reserva_id, $cancha_id, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $reserva = $em->getRepository(Reserva::class)->find($reserva_id);
        if (!$reserva) {
            return new JsonResponse(['error' => 'Reserva no encontrada'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Verificar que la cancha de la reserva coincide con la cancha_id de la ruta
        if ($reserva->getCancha()->getId() != $cancha_id) {
            return new JsonResponse(['error' => 'La cancha de la reserva no coincide con la cancha especificada'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Verificar que el usuario de la reserva coincide con el usuario_id de la ruta
        if ($reserva->getUsuario()->getId() != $usuario_id) {
            return new JsonResponse(['error' => 'No tienes permiso para editar esta reserva'], JsonResponse::HTTP_FORBIDDEN);
        }

        // Validar formato de hora para asegurar que sean cadenas válidas de tiempo
        if (isset($data['hora_reserva']) && !preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/', $data['hora_reserva'])) {
            return new JsonResponse(['error' => 'Formato de hora_reserva inválido'], JsonResponse::HTTP_BAD_REQUEST);
        }
        if (isset($data['hora_fin']) && !preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/', $data['hora_fin'])) {
            return new JsonResponse(['error' => 'Formato de hora_fin inválido'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Crear el formulario y someter los datos
        $form = $this->createForm(ReservaType::class, $reserva, ['csrf_protection' => false]);
        $form->submit($data, false);  // El segundo parámetro `false` indica que no se debe verificar si faltan campos.

        if (!$form->isValid()) {
            return new JsonResponse(['error' => 'Datos inválidos', 'form_errors' => (string) $form->getErrors(true)], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Comprobar conflictos de horario
        $conflictos = $em->getRepository(Reserva::class)->createQueryBuilder('r')
            ->where('r.cancha = :cancha')
            ->andWhere('r.fechaReserva = :fechaReserva')
            ->andWhere('(r.hora_reserva < :hora_fin AND r.hora_fin > :hora_reserva)')
            ->andWhere('r.id != :id')
            ->setParameter('cancha', $cancha_id)
            ->setParameter('fechaReserva', $reserva->getFechaReserva()->format('Y-m-d'))
            ->setParameter('hora_reserva', $reserva->getHoraReserva())
            ->setParameter('hora_fin', $reserva->getHoraFin())
            ->setParameter('id', $reserva_id)
            ->getQuery()
            ->getResult();

        if (count($conflictos) > 0) {
            return new JsonResponse(['error' => 'La cancha ya está reservada en ese horario'], JsonResponse::HTTP_CONFLICT);
        }

        // Manejar comprobante de pago si existe
        if (!empty($data['comprobante_pago'])) {
            $resultado = $this->handleFileUpload($data['comprobante_pago'], $slugger);
            if ($resultado['error']) {
                return new JsonResponse(['error' => $resultado['message']], JsonResponse::HTTP_BAD_REQUEST);
            }
            $reserva->setComprobantePago($resultado['filename']);
        }
        $reserva->setModifiedAt(new \DateTime('now'));
        // Persistir el nuevo usuario en la base de datos
        $em->persist($reserva);
        $em->flush();

        return new JsonResponse(['success' => 'Reserva actualizada correctamente', 'id' => $reserva->getId()], JsonResponse::HTTP_OK);
    }

    //BORRAR/CANCELAR UNA RESERVA

    #[Route('/reserva/{reserva_id}/eliminar', name: 'eliminar_reserva', methods: ['DELETE'])]
    public function eliminarReserva($reserva_id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $reserva = $em->getRepository(Reserva::class)->find($reserva_id);
        if (!$reserva) {
            return new JsonResponse(['error' => 'Reserva no encontrada'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Verificar que la cancha de la reserva coincide con la cancha_id del cuerpo
        if ($reserva->getCancha()->getId() != $data['cancha_id']) {
            return new JsonResponse(['error' => 'La cancha de la reserva no coincide con la cancha especificada'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Verificar que el usuario de la reserva coincide con el usuario_id del cuerpo
        if ($reserva->getUsuario()->getId() != $data['usuario_id']) {
            return new JsonResponse(['error' => 'No tienes permiso para eliminar esta reserva'], JsonResponse::HTTP_FORBIDDEN);
        }

        $em->remove($reserva);
        $em->flush();

        return new JsonResponse(['success' => 'Reserva eliminada correctamente'], JsonResponse::HTTP_OK);
    }

}
