<?php

// src/EventListener/LoginListener.php
namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\SecurityEvents;

class LoginListener implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin',
        ];
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $fecha = new \DateTime();
        $mensajeLog = $fecha->format('Y-m-d H:i:s') . " - El usuario: " . $user->getUserIdentifier() . " ha iniciado sesión";
        $this->logger->info($mensajeLog); // Usa 'info' en lugar de 'debug'
    }
}