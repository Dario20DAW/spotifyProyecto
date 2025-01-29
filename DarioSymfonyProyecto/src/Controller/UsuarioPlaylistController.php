<?php

namespace App\Controller;
use App\Entity\Usuario;
use App\Entity\Playlist;
use App\Entity\UsuarioPlaylist;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class UsuarioPlaylistController extends AbstractController
{
    #[Route('/usuario/playlist', name: 'app_usuario_playlist')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UsuarioPlaylistController.php',
        ]);
    }



    #[Route('/usuarioPlaylist/new', name: 'app_usuario_playlist_crear')]
    public function crearUsuarioPlaylist(EntityManagerInterface $entityManager): JsonResponse
    {

        $usuarioRepository = $entityManager->getRepository(Usuario::class);
        $usuario = $usuarioRepository->findOneByNombre('Dario');


        $playlistRepository = $entityManager->getRepository(Playlist::class);
        $playlist = $playlistRepository->findOneByNombre('Playlist 1');

        $UsuarioPlaylist = new UsuarioPlaylist();
        $UsuarioPlaylist->setPlaylist($playlist);
        $UsuarioPlaylist->setUsuario($usuario);
        $UsuarioPlaylist->setReproducida(20);
        $entityManager->persist($UsuarioPlaylist);
        $entityManager->flush();


        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UsuarioPlaylistController.php',
        ]);
    }
}
