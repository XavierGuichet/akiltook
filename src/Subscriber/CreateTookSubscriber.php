<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManager;
use App\Entity\Consummable;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class CreateTookSubscriber implements EventSubscriberInterface
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                                  ['addCreatedBy', EventPriorities::PRE_WRITE]
        ]
        ];
    }

    public function addCreatedBy(GetResponseForControllerResultEvent $event)
    {
        $took = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$took instanceof Consummable || Request::METHOD_POST !== $method) {
            return;
        }

        $user = $this->tokenStorage->getToken()->getUser();

        $took->setCreatedBy($user);
    }
}
