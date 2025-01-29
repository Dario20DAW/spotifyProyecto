<?php

namespace App\Controller;
use App\Entity\Playlist;
use App\Entity\Cancion;
use App\Entity\PlaylistCancion;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PlaylistCancionController extends AbstractController
{
    #[Route('/playlist/cancion', name: 'app_playlist_cancion')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PlaylistCancionController.php',
        ]);
    }

    #[Route('/playlistCancion/new', name: 'app_playlist_cancion_crear')]
    public function crearCancion(EntityManagerInterface $entityManager): JsonResponse
    {

        $playlistRepository = $entityManager->getRepository(Playlist::class);
        $playlist = $playlistRepository->findOneByNombre('Playlist 1');

        $cancionRepository = $entityManager->getRepository(Cancion::class);
        $cancion = $cancionRepository->findOneByTitulo('La vereda de la puerta de atras');

        $playlistCancion = new PlaylistCancion();
        $playlistCancion->setPlaylist($playlist);
        $playlistCancion->setCancion($cancion);
        $entityManager->persist($playlistCancion);
        $entityManager->flush();

        return $this->json([
            'message' => 'Playlist Cancion creada',
            'path' => 'src/Controller/PlaylistCancionController.php',
        ]);
    }
}


