<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\Cancion;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EstadisticasController extends AbstractController
{
    #[Route('/estadisticas', name: 'app_estadisticas')]
    public function index(): Response
    {
        return $this->render('estadisticas/index.html.twig', [
            'controller_name' => 'EstadisticasController',
        ]);
    }


    #[Route('/estadisticas/playlist/likes', name: 'estadisticas_playlist_likes', methods: ['GET'])]
    public function playlistLikes(EntityManagerInterface $e): JsonResponse
    {
        $playlistRepository = $e->getRepository(Playlist::class);
        $resultado = $playlistRepository->getPlaylistsPorLikes();

        return $this->json($resultado);
    }



    #[Route('/estadisticas/playlist/reproducciones', name: 'estadisticas_playlist_reproducciones', methods: ['GET'])]
    public function playlistReproducciones(EntityManagerInterface $e): JsonResponse
    {
        $playlistRepository = $e->getRepository(Playlist::class);
        $resultado = $playlistRepository->getPlaylistsPorReproducciones();

        return $this->json($resultado);
    }





    #[Route('/estadisticas/cancion/reproducciones', name: 'estadisticas_cancion_reproducciones', methods: ['GET'])]
    public function cancionReproducciones(EntityManagerInterface $e): JsonResponse
    {
        $cancionRepository = $e->getRepository(Cancion::class);
        $resultado = $cancionRepository->getCancionesMasReproducidas();

        return $this->json($resultado);
    }


    #[Route('/estadisticas/estilo/reproducciones', name: 'estadisticas_estilo_reproducciones', methods: ['GET'])]
    public function estiloReproducciones(EntityManagerInterface $e): JsonResponse
    {
        $cancionRepository = $e->getRepository(Cancion::class);
        $resultado = $cancionRepository->getReproduccionesPorEstilo();

        return $this->json($resultado);
    }


    #[Route('/estadisticas/usuario/edades', name: 'estadisticas_usuario_edades', methods: ['GET'])]
    public function usuarioEdades(EntityManagerInterface $e): JsonResponse
    {
        $usuarioRepository = $e->getRepository(Usuario::class);
        $fechasNacimiento = $usuarioRepository->getDistribucionEdadesUsuarios();
    
        $hoy = new \DateTime();
        $edades = [];
    
        // Validar si la consulta devolvió resultados
        if (empty($fechasNacimiento)) {
            return $this->json(['error' => 'No se encontraron usuarios con fecha de nacimiento']);
        }
    
        foreach ($fechasNacimiento as $fila) {
            if (isset($fila['fechaNacimiento']) && $fila['fechaNacimiento'] instanceof \DateTimeInterface) {
                $edad = $hoy->diff($fila['fechaNacimiento'])->y;
                $edades[] = $edad;
            }
        }
    
        // Validar si se obtuvieron edades
        if (empty($edades)) {
            return $this->json(['error' => 'No se pudieron calcular las edades']);
        }
    
        $rangos = [
            '0-18' => 0,
            '19-25' => 0,
            '26-35' => 0,
            '36-45' => 0,
            '46 o más' => 0,
        ];
    

        foreach ($edades as $edad) {
            if ($edad <= 18) {
                $rangos['0-18']++;
            } elseif ($edad <= 25) {
                $rangos['19-25']++;
            } elseif ($edad <= 35) {
                $rangos['26-35']++;
            } elseif ($edad <= 45) {
                $rangos['36-45']++;
            } else {
                $rangos['46 o más']++;
            }
        }
    
        // Transformar a un formato JSON adecuado
        $resultado = [];
        foreach ($rangos as $rango => $cantidad) {
            $resultado[] = ['rango' => $rango, 'cantidad' => $cantidad];
        }
    
        return $this->json($resultado);
    }
    
}