<?php

namespace App\Controller;

use App\Entity\Arbitro;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{

    private $jwtEncoder;

    public function __construct(JWTEncoderInterface $jwtEncoder)
    {
        $this->jwtEncoder = $jwtEncoder;
    }


    //CONTROL DEL LOGIN DEL USUARIOS
    //VERIFICA SI EL PASSWORD UNA VEZ DESCRIPTADO ES EL CORRETO Y PERTENECE AL USUARIO

    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function login(Request $request, EntityManagerInterface $em): JsonResponse
    {
        // Obtener los datos del cuerpo de la solicitud
        $data = json_decode($request->getContent(), true);

        // Obtener el correo electrónico y la contraseña del cuerpo de la solicitud
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        // Verificar si el correo electrónico y la contraseña están presentes
        if (!$email || !$password) {
            return new JsonResponse(['error' => 'Email y el  password son obligatorios'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Buscar el usuario por su correo electrónico en la base de datos
        $usuario = $em->getRepository(Usuario::class)->findOneBy(['email' => $email]);

        // Verificar si el usuario existe
        if (!$usuario) {
            $usuario = $em->getRepository(Arbitro::class)->findOneBy(['email' => $email]);
        }

        // Verificar si el usuario existe
        if (!$usuario) {
            return new JsonResponse(['error' => 'El correo es inválido'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Verificar si la contraseña proporcionada coincide con la contraseña almacenada
        if (!password_verify($password, $usuario->getPassword())) {
            return new JsonResponse(['error' => 'El password no es correcto'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Obtener el rol del usuario
        $rol = $usuario->getRol();

        // Crear un array de datos del usuario para incluir en el token JWT
        $userData = [
            'email' => $usuario->getEmail(),
            'rol_id' => $rol->getId()
            // Otros datos del usuario que quieras incluir en el token
        ];

        // Generar el token JWT
        $token = $this->jwtEncoder->encode($userData);

        // Devolver el token JWT en la respuesta
        return new JsonResponse(['token' => $token]);
    }

}
