<?php
// src/AppBundle/Security/User/WebserviceUserProvider.php

namespace App\Provider;
use App\Entity\Account;
use Symfony\Component\HttpFoundation\Session\Session;

use Doctrine\ORM\EntityManager;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityManagerInterface;

class AccountProvider implements UserProviderInterface
{
    private $em;
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function loadUserByUsername($emailOrUsername)
    {
        $userData = $this->em->getRepository(Account::class)->loadUserByEmailOrUsername($emailOrUsername);
        if ($userData !== null) {
            return $userData;
        }
        throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $emailOrUsername));
    }
    
    public function refreshUser(UserInterface $user)
    {

    }

    public function supportsClass($class) {
        return Account::class === $class;
    }
}
