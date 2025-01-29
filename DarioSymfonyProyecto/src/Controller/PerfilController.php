<?php

namespace App\Controller;
use App\Entity\Perfil;
use App\Entity\Estilo;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PerfilController extends AbstractController
{
    #[Route('/perfil', name: 'app_perfil')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PerfilController.php',
        ]);
    }

    #[Route('/perfil/new', name: 'app_perfil')]
    public function crearPerfil(EntityManagerInterface $entityManager): JsonResponse
    {

        $perfil = new Perfil();
        $perfil->setFoto('foto');
        $perfil->setDescripcion('Le gusta el Rock español');

        $estiloRepository = $entityManager->getRepository(Estilo::class);
        $estilo = $estiloRepository->findOneByNombre('Rock Español');
        $perfil->setEstiloMusicalPreferido($estilo);
        
        
        $entityManager->persist($perfil);
        $entityManager->flush();

        return $this->json([
            'message' => 'Perfil creado',
            'path' => 'src/Controller/PerfilController.php',
        ]);
    }
}
