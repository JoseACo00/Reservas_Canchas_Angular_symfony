<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
class ResetPasswordController extends AbstractController
{



    private $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    /**
     * Endpoint para enviar un correo de restablecimiento de contraseña.
     *
     * @Route("/reset_password", name="reset_Password", methods={"POST"})
     *
     * Este endpoint genera un token de restablecimiento de contraseña y envía un correo electrónico al usuario con un enlace para restablecer su contraseña.
     *
     * @param Request $request La solicitud HTTP.
     * @param MailerInterface $mailer El servicio de envío de correos.
     * @param UsuarioRepository $usuarioRepository El repositorio de la entidad Usuario.
     * @param TokenGeneratorInterface $tokenGenerator El generador de tokens de restablecimiento.
     * @param EntityManagerInterface $em El gestor de entidades.
     * @return JsonResponse La respuesta JSON con el resultado de la operación.
     */
    #[Route('/reset_password', name: 'reset_Password')]
    public function sendEmail ( Request $request ,MailerInterface $mailer, UsuarioRepository  $usuarioRepository, TokenGeneratorInterface  $tokenGenerator,EntityManagerInterface $em): JsonResponse //Response Simpere Json
    {

        // Obtener los datos del cuerpo de la solicitud
        $data = json_decode($request->getContent(), true);
        // Obtener el correo electrónico y la contraseña del cuerpo de la solicitud
        $email = $data['email'] ?? null;

        //Verificar que el correo electronico fue introducido
        if(!$email){
            // UTILIZAR JSON RESPONSE return  new Response(['Message' => 'El email es necesario'], JsonResponse::HTTP_BAD_REQUEST);
            return new JsonResponse(['error' => 'El email es necesario'], JsonResponse::HTTP_BAD_REQUEST);

        }

        // Buscar al usuario por su correo electrónico
        $usuario = $usuarioRepository->findOneBy(['email' => $email]);

        if (!$usuario) {
            return new JsonResponse(['error' => 'No se encontró ningún usuario relacionado con este correo electrónico'], JsonResponse::HTTP_NOT_FOUND);
        }

        try {

            // 1 Generar y almacenar el token para el usuario
            $token = $tokenGenerator->generateToken();
            $usuario->setResetPassword($token);
            $em->persist($usuario);
            $em->flush();
            // Generar la URL para el restablecimiento de contraseña
            //$resetUrl = 'http://tuaplicacion.com/reset_password?token=' . $token;
            $resetUrl = 'http://localhost:4200/reset-password?token=' . $token;

            //-------------------------

            //2 ENVIAMOS EL EMAIL
            $email = (new Email())
                ->from('footcap7@gmail.com')
                ->to($email)
                ->subject('Restablecer contraseña olvidada')
                ->html('<p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p><p><a href="' . $resetUrl . '">Restablecer contraseña</a></p>');

            $mailer->send($email);
            //return  new Response('El mail fue enviado correctamente');
            return new JsonResponse(['message' => 'El correo fue enviado correctamente']);

        } catch (\Throwable $th) {
            return new JsonResponse(['error' => $th->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);

        }
    }


    /**
     * Endpoint para cambiar la contraseña del usuario.
     *
     * @Route("/reset-password/{token}", name="app_reset", methods={"POST"})
     *
     * Este endpoint permite a un usuario cambiar su contraseña utilizando un token de restablecimiento válido.
     *
     * @param Request $request La solicitud HTTP.
     * @param string $token El token de restablecimiento de contraseña.
     * @param EntityManagerInterface $em El gestor de entidades.
     * @return JsonResponse La respuesta JSON con el resultado de la operación.
     */
    #[Route('/reset-password/{token}', name: 'app_reset')]
    public function cambiarPassword(Request $request, string $token, EntityManagerInterface $em): JsonResponse
    {
        // Obtener los datos del formulario enviado por el cliente
        $data = json_decode($request->getContent(), true);
        $password = $data['password'] ?? null;

        // Verificar si se proporcionó una contraseña nueva
        if (!$password) {
            return new JsonResponse(['error' => 'La contraseña nueva es obligatoria'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Buscar el usuario por el token de restablecimiento de contraseña
        $usuario = $em->getRepository(Usuario::class)->findOneBy(['reset_password' => $token]);

        // Verificar si se encontró un usuario con el token proporcionado
        if (!$usuario) {
            return new JsonResponse(['error' => 'Token de restablecimiento de contraseña no válido'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Encriptar la nueva contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $usuario->setPassword($hashedPassword);


        // Eliminar el token de restablecimiento de contraseña
        // Tema de suguridad para que no te pueda coger el token
        $usuario->setResetPassword(null);


        // Guardar los cambios en la base de datos
        try {
            $em->flush(); // Guardar los cambios en la base de datos

            return new JsonResponse(['message' => 'Contraseña actualizada correctamente'], JsonResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    //GENERAMOS EL TOKEN DE MANERA  Y SE IMPLEMENTA EN LA FUNCIÓN PRINCIPAL
    public function generateToken(Request $request, TokenGeneratorInterface  $tokenGenerator, Usuario $usuario, EntityManagerInterface $em)
    {

        try{
            //Generamos el token
            $token = $tokenGenerator->generateToken();

            // Almacenar el token en la base de datos
            $usuario->setResetPassword($token);
            $em->persist($usuario);
            $em->flush();

            // Generar la URL para el restablecimiento de contraseña
            $url = $this->generateUrl('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

            // Retornar una respuesta JSON con la URL generada
            return new JsonResponse([' Esta es la Url creada con el token url:' => $url], JsonResponse::HTTP_OK);

        }catch (\Exception $exception) {
            // Manejar errores y retornar una respuesta de error
            return new JsonResponse(['error' => $exception->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
