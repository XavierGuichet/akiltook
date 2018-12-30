<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManager;
use App\Entity\Account;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class RegistrationSubscriber implements EventSubscriberInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                                  ['encodePwd', EventPriorities::PRE_WRITE]
        ]
        ];
    }

    public function encodePwd(GetResponseForControllerResultEvent $event)
    {
        $account = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$account instanceof Account || Request::METHOD_POST !== $method) {
            return;
        }
      
        $plainPassword = $account->getPassword();
        
        $account->setPassword($this->encoder->encodePassword($account, $plainPassword));
        $account->eraseCredentials();
    }
}
