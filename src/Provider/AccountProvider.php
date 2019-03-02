<?php
// src/AppBundle/Security/User/WebserviceUserProvider.php

namespace App\Provider;
use App\Entity\Account;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityManagerInterface;

class AccountProvider implements UserProviderInterface, OAuthAwareUserProviderInterface
{
    private $em;

    private $accountRepo;

    private $oauthProperties;

    public function __construct(EntityManagerInterface $em, array $oauthProperties) {
        $this->em = $em;
        $this->accountRepo = $this->em->getRepository(Account::class);
        $this->oauthProperties = $oauthProperties;
    }

    /**
     * {@inheritDoc}
     */
    // Add a Oauth login method/id to current user
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        throw new \Exception("Not implemented", 1);
    }

    public function loadUserByUsername($emailOrUsername)
    {
        $userData = $this->accountRepo->loadUserByEmailOrUsername($emailOrUsername);
        if ($userData !== null) {
            return $userData;
        }
        throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $emailOrUsername));
    }

    /**
     * Loads the user by a given UserResponseInterface object.
     * If User is unknow, register User
     *
     * @param UserResponseInterface $response
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $property = $this->getOAuthProperty($response);
        $oauthId = $response->getUsername();

        if (null === $oauthId) {
          throw new \Exception("No OAuth ID", 1);
        }

        $account = $this->accountRepo->loadUserByOAuth($property, $oauthId);

        if ($account) {
          return $account;
        }

        $email = $response->getEmail();
        // check if we already have this user
        $account = $this->accountRepo->findBy(array('email' => $email));
        if ($account instanceof Account) {
            // in case of Facebook login, update the facebook_id
            if ($property == "facebookId") {
                $existingAccount->setFacebookId($oauthId);
            }
            // in case of Google login, update the google_id
            if ($property == "googleId") {
                $existingAccount->setGoogleId($oauthId);
            }
            $this->em->persist($account);
            $this->em->flush();

            return $account;
        }

        // We don't know the user, create it
        $account = new Account();
        $username = $response->getRealName();
        $account->setUsername($username);
        $account->setEmail($response->getEmail());
        $account->setPassword(sha1(uniqid()));
        $account->addRoles('ROLE_USER');

        if ($property == "facebookId") {
            $account->setFacebookId($oauthId);
        }
        if ($property == "googleId") {
            $account->setGoogleId($oauthId);
        }
        $this->em->persist($account);
        $this->em->flush();

        return $account;
    }

    /**
     * Gets the property for the response.
     *
     * @param UserResponseInterface $response
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected function getOAuthProperty(UserResponseInterface $response)
    {
        $resourceOwnerName = $response->getResourceOwner()->getName();

        if (!isset($this->oauthProperties[$resourceOwnerName])) {
            throw new \RuntimeException(sprintf("No property defined for entity for resource owner '%s'.", $resourceOwnerName));
        }

        return $this->oauthProperties[$resourceOwnerName];
    }

    public function refreshUser(UserInterface $user)
    {

    }

    public function supportsClass($class) {
        return Account::class === $class;
    }
}
