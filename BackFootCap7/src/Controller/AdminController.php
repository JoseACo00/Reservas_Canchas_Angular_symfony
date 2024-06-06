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
use JMS\Serializer\SerializerInterface;
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

    private $serializer;
    public function   __construct(AdminRepository $AdminRepository, CanchaRepository $CanchaRepository, SerializerInterface $serializer)
    {
        $this->AdminRepository = $AdminRepository;
        $this->CanchaRepository = $CanchaRepository;
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





}
