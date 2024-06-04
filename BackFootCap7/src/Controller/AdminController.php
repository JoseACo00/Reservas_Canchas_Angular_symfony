<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Arbitro;
use App\Entity\Cancha;
use App\Entity\Rol;
use App\Form\AdminType;
use App\Form\CanchaType;
use App\Repository\AdminRepository;
use App\Repository\CanchaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminController extends AbstractController
{

    private $CanchaRepository;
    private $AdminRepository;
    public function   __construct(AdminRepository $AdminRepository, CanchaRepository $CanchaRepository)
    {
        $this->AdminRepository = $AdminRepository;
        $this->CanchaRepository = $CanchaRepository;
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


    //CREAR CANCHA DE FUTBOL
    #[Route('/registrarCancha', name: 'registrarCancha', methods: ['POST'])]
    public function crearCancha(Request $request, EntityManagerInterface $em, SluggerInterface $slugger)
    {

        $data = json_decode($request->getContent(), true);

        $cancha = new Cancha();

        $canchaForm = $this->createForm(CanchaType::class, $cancha);
        $canchaForm->submit($data);

        if($canchaForm->isValid()){
            $cancha = $canchaForm->getData();
            $imagenFile = $canchaForm->get('imagen')->getData();

            //Evitar archivos extraños con nombre raros
            if($imagenFile){
                $originalFilename = pathinfo($imagenFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imagenFile->guessExtension();
                try {
                    $imagenFile->move($this->getParameter('image_directory'), $newFilename);
                } catch (FileException $e) {
                    return new JsonResponse(['error' => 'There was an error uploading your file.'], JsonResponse::HTTP_BAD_REQUEST);
                }
                $cancha->setImagen($newFilename);
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
    #[Route('/Cancha/{cancha_id}/edit', name: 'actualizarCancha', methods: ['PUT'])]
    public function editarCancha(Request $request, $cancha_id,EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $data = json_decode($request->getContent(), true);
        $cancha = $this->CanchaRepository->find($cancha_id);

        if(!$cancha){
            return new JsonResponse(['error' => 'La cancha id no fue encontrada'], JsonResponse::HTTP_NOT_FOUND);
        }

        $canchaForm = $this->createForm(CanchaType::class, $cancha);
        $canchaForm->submit($data);

        if(!$canchaForm->isValid()){
            // Construir un array de errores de validación
            $errors = [];
            foreach ($canchaForm->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }
            return new JsonResponse(['error' => $errors], JsonResponse::HTTP_BAD_REQUEST);
        }

        $cancha->setModifiedAt(new \DateTime('now'));

        $em->persist($cancha);
        $em->flush();

        return new JsonResponse(['success' => 'Cancha actualizada correctamente', 'cancha' => $cancha]);
    }



    //DELETE DE CANCHA
    #[Route('/Cancha/{cancha_id}/delete', name: 'actualizarCancha', methods: ['DELETE'])]
    public function eliminarCancha(Request $request, $cancha_id,EntityManagerInterface $em, SluggerInterface $slugger)
    {

        $cancha = $this->CanchaRepository->find($cancha_id);

        if(!$cancha){
            return new JsonResponse(['error' => 'La cancha no existe'], JsonResponse::HTTP_NOT_FOUND);
        }

        $cancha->setDeletedAt(new \DateTime('now'));

        $em->persist($cancha);
        $em->flush();

        return new JsonResponse(['message' => 'La cancha con el nombre: ' .$cancha->getNombre().' fue borrada'], JsonResponse::HTTP_OK);

    }


    //EDITAR RESERVA





}
