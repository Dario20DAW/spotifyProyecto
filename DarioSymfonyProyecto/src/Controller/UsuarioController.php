<?php

namespace App\Controller;

use App\Entity\Perfil;
use App\Entity\Usuario;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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


    #[Route('/getSession', name: 'app_obtener_sesion')]
    public function session(Request $request): JsonResponse
    {
        $session = $request->getSession();

        $email = $session->get('_security.last_username', null); 
    
        return $this->json(['email' => $email]);
    }


    #[Route('/usuario/mostrarId/{email}', name: 'app_obtener_idUsuario')]
    public function obtenerUsuario(EntityManagerInterface $e, string $email ): JsonResponse
    {
       
        $UsuarioRep = $e->getRepository(Usuario::class);
        $usuario = $UsuarioRep->findOneByEmail($email);

        $usuarioId = $usuario->getId();
       
    
        return $this->json(['id' => $usuarioId]);
    }
    #[Route('/usuario/mostrarRol/{email}', name: 'app_obtener_idUsuario')]
    public function obtenerUsuarioRol(EntityManagerInterface $e, string $email ): JsonResponse
    {
       
        $UsuarioRep = $e->getRepository(Usuario::class);
        $usuario = $UsuarioRep->findOneByEmail($email);

        $usuarioRol= $usuario->getRoles();
       
    
        return $this->json(['rol' => $usuarioRol]);
    }
}
