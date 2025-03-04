<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\Usuario;
use App\Entity\PlaylistCancion;
use App\Entity\UsuarioPlaylist;
use App\Form\PlaylistType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

final class PlaylistController extends AbstractController
{


    #[Route('/playlist', name: 'app_playlist')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PlaylistController.php',
        ]);
    }


    #[Route('/playlist/new', name: 'app_playlist_crear')]
    public function crearPlaylist(EntityManagerInterface $entityManager): JsonResponse
    {

        $usuarioRepository = $entityManager->getRepository(Usuario::class);
        $usuario = $usuarioRepository->findOneByNombre('Dario');


        $playlist = new Playlist();
        $playlist->setNombre('Playlist 1');
        $playlist->setVisibilidad('Publica');
        $playlist->setPropietario($usuario);
        $playlist->setReproducciones(23);
        $playlist->setLikes(1);
        $entityManager->persist($playlist);
        $entityManager->flush();

        return $this->json([
            'message' => 'playlist creada',
            'path' => 'src/Controller/PlaylistController.php',
        ]);
    }




    #[Route('/playlist/mostrarPlaylist', name: 'app_mostrar_playlists')]
    public function verPlaylists(EntityManagerInterface $entityManager): JsonResponse
    {
        $playlistRep = $entityManager->getRepository(Playlist::class);
        $playlists = $playlistRep->findAllPlaylists();
        $datosPlaylist = [];

        foreach ($playlists as $playlist) {
            $propietario = $playlist->getPropietario();

            $datosPlaylist[] = [
                'nombre' => $playlist->getNombre(),
                'propietario' => $propietario ? $propietario->getId() : null,
                'rolPropietario' => $propietario ? $propietario->getRoles() : null
            ];
        }

        return $this->json($datosPlaylist);
    }




    #[Route('/playlist/{playlistName}/find', name: 'app_buscar_playlists', methods: ['GET'])]
    public function buscarPlaylist(EntityManagerInterface $entityManager, string $playlistName): JsonResponse
    {
        $playlistRep = $entityManager->getRepository(Playlist::class);
        $playlist = $playlistRep->findOneByNombre($playlistName);

        $jsonResultado = [];

        foreach ($playlist->getPlaylistCanciones() as $playlistCancion) {
            $jsonResultado[] = [
                'id' => $playlistCancion->getCancion()->getId(),
                'titulo' => $playlistCancion->getCancion()->getTitulo(),
                'artista' => $playlistCancion->getCancion()->getAutor(),
                'portada' => $playlistCancion->getCancion()->getImagenCancion()
            ];
        }

        return $this->json($jsonResultado);
    }



    #[Route('/playlist/crear', name: 'app_crear_playlist')]
    public function crearPlaylistForm(Request $request, EntityManagerInterface $entityManager): Response
    {
        $playlist = new Playlist();
        $form = $this->createForm(PlaylistType::class, $playlist);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            // Obtener el usuario actual
            $UsuarioRep = $entityManager->getRepository(Usuario::class);
            $session = $request->getSession();


            $email = $session->get('_security.last_username', null);
            $usuario = $UsuarioRep->findOneByEmail($email);


            // Asignar el propietario de la playlist
            $playlist->setPropietario($usuario);

            // Obtener las canciones seleccionadas
            $canciones = $form->get('canciones')->getData();

            // Crear las entidades PlaylistCancion para cada canción seleccionada
            foreach ($canciones as $cancion) {
                $playlistCancion = new PlaylistCancion();
                $playlistCancion->setPlaylist($playlist);
                $playlistCancion->setCancion($cancion);
                $entityManager->persist($playlistCancion);
            }

            // Guardar la playlist en la base de datos
            $playlist->setReproducciones(0);
            $playlist->setLikes(0);
            $entityManager->persist($playlist);
            $entityManager->flush();


            //Guardar playlist y propietario
            $UsuarioPlaylist = new UsuarioPlaylist();
            $UsuarioPlaylist->setUsuario($usuario);
            $UsuarioPlaylist->setPlaylist($playlist);
            $UsuarioPlaylist->setReproducida(0);
            $entityManager->persist($UsuarioPlaylist);
            $entityManager->flush();

            // Redirigir a alguna página de éxito
            return $this->redirect('/');
        }

        return $this->render('playlist/crear.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
