<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Psr\Log\LoggerInterface;


final class LoginController extends AbstractController
{

    #[Route('/login', name: 'app_login')]
public function index(AuthenticationUtils $authenticationUtils): Response
{
    $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('login/index.html.twig', [
        'controller_name' => 'LoginController',
        'last_username' => $lastUsername,
        'error' => $error,
    ]);
}

#[Route('/login/success', name: 'app_login_success')]
public function loginSuccess(LoggerInterface $logger): Response
{
    if ($this->getUser()) {
        $fecha = new \DateTime();
        $mensajeLog = $fecha->format('Y-m-d H:i:s') . " - El usuario: " . $this->getUser()->getUserIdentifier() . " ha iniciado sesión";
        $logger->info($mensajeLog); 
    }

    return $this->redirect('/'); // Redirige al usuario a la página de inicio
}



    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Symfony maneja el logout internamente, así que no hace falta lanzar una excepción
        throw new \Exception('No olvides configurar el firewall en security.yaml');
    }
}
