<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Arbitro;
use App\Entity\Rol;
use App\Form\AdminType;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class AdminController extends AbstractController
{

    private $AdminRepository;
    public function   __construct(AdminRepository $AdminRepository)
    {
        $this->AdminRepository = $AdminRepository;
    }

    //CREACION DE ADMIN

    #[Route('/registrarAdmin', name: 'registrarAdmin', methods: ['POST'])]
    public function registrarAdmin(Request $request, EntityManagerInterface $em)
    {

        // Decodificar los datos JSON de la solicitud
        $data = json_decode($request->getContent(), true);

        $admin = new Admin();

        $adminForm = $this->createForm(AdminType::class, $admin);
        $adminForm->submit($data);

        if(!$adminForm->isValid()){
            $adminForm;
        }

        $existEmailAdmin = $em->getRepository(Arbitro::class)->findOneBy(['email'=> $admin->getEmail()]);

        if($existEmailAdmin){
            return new JsonResponse(['error' => 'El correo electrónico ya está en uso por otro Admin'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $exitPhoneAdmin = $em->getRepository(Arbitro::class)->findOneBy(['phone'=> $admin->getPhone()]);

        if($exitPhoneAdmin){
            return new JsonResponse(['error' => 'El phone ya pertenece a otro Admin'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Si el número de teléfono ya existe, devuelve un mensaje de error
        if ($exitPhoneAdmin) {
            return new JsonResponse(['error' => 'El número de teléfono ya está en uso por otro usuario'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $rolAdmin = $em->getRepository(Rol::class)->find(1);
        if(!$rolAdmin){
            return  new JsonResponse(['error' => 'No se encontro el rol'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $admin->setRol($rolAdmin);
        // Encriptar la contraseña utilizando password_hash()
        $hashedPassword = password_hash($admin->getPassword(), PASSWORD_DEFAULT);
        $admin->setPassword($hashedPassword);

        $admin->setCreatedAt(new \DateTime('now'));
        $em->persist($admin);
        $em->flush();

        return new JsonResponse(['message' => 'Admin creado'], JsonResponse::HTTP_CREATED);



    }

}
