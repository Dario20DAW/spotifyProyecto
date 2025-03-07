<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\Request;

class ErrorController extends AbstractController
{
    #[Route('/error', name: 'app_error')]
    public function showError(Request $request): Response
    {
        $exception = $request->attributes->get('exception');
        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;

        return $this->render('error/error.html.twig', [
            'message' => 'Ha ocurrido un error inesperado.',
            'status_code' => $statusCode,
            'home_url' => '/'
        ], new Response('', $statusCode));
    }
}
