<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UsuarioController extends AbstractController
{

    private $UsuarioRepository;

    public function __construct(UsuarioRepository $UsuarioRepository)
    {
        $this->UsuarioRepository = $UsuarioRepository;
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
}
