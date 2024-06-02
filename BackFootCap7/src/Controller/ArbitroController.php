<?php

namespace App\Controller;

use App\Entity\Arbitro;
use App\Entity\Rol;
use App\Form\ArbitroType;
use App\Repository\ArbitroRepository;
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

    public function __construct(ArbitroRepository $ArbitroRepository)
    {
        $this->ArbitroRepository = $ArbitroRepository;
    }

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

}
