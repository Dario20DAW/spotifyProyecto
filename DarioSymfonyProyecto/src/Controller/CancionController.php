<?php

namespace App\Controller;
use App\Entity\Estilo;
use App\Entity\Cancion;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class CancionController extends AbstractController
{
    #[Route('/cancion', name: 'app_cancion')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CancionController.php',
        ]);
    }


    #[Route('/cancion/new', name: 'app_cancion_crear')]
    public function crearCancion(EntityManagerInterface $entityManager): JsonResponse
    {

        $estiloRepository = $entityManager->getRepository(Estilo::class);
        $estilo = $estiloRepository->findOneByNombre('Rock Español');
        

        $cancion1 = new Cancion();
        $cancion1->setTitulo('La vereda de la puerta de atras');
        $cancion1->setDuracion(345);
        $cancion1->setAlbum('Yo, minoria absoluta');
        $cancion1->setAutor('Extremoduro');
        $cancion1->setGenero($estilo);
        $cancion1->setReproducciones(22222222);
        $cancion1->setLikes(1111111);

        $entityManager->persist($cancion1);
        $entityManager->flush();

        return $this->json([
            'message' => 'Creada nueva cancion',
            'path' => 'src/Controller/CancionController.php',
        ]);
    }


    #[Route('/cancion/prueba', name: 'app_cancion_prueba')]
    public function verCanciones(EntityManagerInterface $entityManager): JsonResponse
    {
        $canionRep = $entityManager->getRepository(Cancion::class);
        $canciones = $canionRep->findAll();
        $cancionTitulo = "";



        foreach($canciones as $cancion){
            $cancionTitulo .= $cancion->getTitulo();
        }
        return $this->json([
            'message' => $cancionTitulo,
            'path' => 'src/Controller/CancionController.php',
        ]);
    }
}
