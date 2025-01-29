<?php

namespace App\Controller;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Estilo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class EstiloController extends AbstractController
{
    #[Route('/estilo', name: 'app_estilo')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/EstiloController.php',
        ]);
    }

    #[Route('/estilo/new', name: 'app_estilo_crear')]
    public function crearEstilo(EntityManagerInterface $entityManager): JsonResponse
    {
        $estilo = new Estilo();
        $estilo->setNombre('Rock Español');
        $estilo->setDescripcion('Rock de grupos españoles');
        $entityManager->persist($estilo);
        $entityManager->flush();


        return $this->json([
            'message' => 'Has creado un nuevo estilo',
            'path' => 'src/Controller/EstiloController.php',
        ]);
    }
}
