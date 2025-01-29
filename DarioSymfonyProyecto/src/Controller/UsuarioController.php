<?php

namespace App\Controller;

use App\Entity\Perfil;
use App\Entity\Usuario;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class UsuarioController extends AbstractController
{
    #[Route('/usuario', name: 'app_usuario')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UsuarioController.php',
        ]);
    }

    #[Route('/usuario/new', name: 'app_usuario_crear')]
    public function crearUsuario(EntityManagerInterface $entityManager): JsonResponse
    {
        $usuario = new Usuario();
        $usuario->setEmail('usuario1@email.com');
        $usuario->setPassword('1234');
        $usuario->setNombre('Dario');
        $fechaNacimiento = new DateTime('2003-09-20');
        $usuario->setFechaNacimiento($fechaNacimiento);

        $perfilRepository = $entityManager->getRepository(Perfil::class);
        $perfil = $perfilRepository->find(2);
        $usuario->setPerfil($perfil);

        $entityManager->persist($usuario);
        $entityManager->flush();
        


        return $this->json([
            'message' => 'usuario creado',
            'path' => 'src/Controller/UsuarioController.php',
        ]);
    }
}
