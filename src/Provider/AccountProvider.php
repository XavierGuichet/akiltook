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
    public function __construct(EntityManagerInterface $em, array $properties) {
      // dump('account provider constructed');
        $this->em = $em;
    }

    /**
     * {@inheritDoc}
     */
    // Add a Oauth login method/id to current user
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        // dump('by connect');
        // get property from provider configuration by provider name
        // , it will return `facebook_id` in that case (see service definition below)
        $property = $this->getProperty($response);
        $username = $response->getUsername(); // get the unique user identifier

        //we "disconnect" previously connected users
        $existingUser = $this->userManager->findUserBy(array($property => $username));
        if (null !== $existingUser) {
            // set current user id and token to null for disconnect
            // ...

            $this->userManager->updateUser($existingUser);
        }
        // we connect current user, set current user id and token
        // ...
        $this->userManager->updateUser($user);
    }

    public function loadUserByUsername($emailOrUsername)
    {
        // dump('by UserName');
        $userData = $this->em->getRepository(Account::class)->loadUserByEmailOrUsername($emailOrUsername);
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
        $username = $response->getUsername();
        $property = $this->getProperty($response);

        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));

        $email = $response->getEmail();

        // check if we already have this user
        $existing = $this->userManager->findUserBy(array('email' => $email));
        if ($existing instanceof User) {
            // in case of Facebook login, update the facebook_id
            if ($property == "facebookId") {
                $existing->setFacebookId($username);
            }
            // in case of Google login, update the google_id
            if ($property == "googleId") {
                $existing->setGoogleId($username);
            }
            $this->userManager->updateUser($existing);

            return $existing;
        }

        // if we don't know the user, create it
        if (null === $user || null === $username) {
            /** @var User $user */
            $user = $this->userManager->createUser();
            $nick = "johndoe"; // to be changed

            $user->setLastLogin(new \DateTime());
            $user->setEnabled(true);

            $user->setUsername($nick);
            $user->setUsernameCanonical($nick);
            $user->setPassword(sha1(uniqid()));
            $user->addRole('ROLE_USER');

            if ($property == "facebookId") {
                $user->setFacebookId($username);
            }
            if ($property == "googleId") {
                $user->setGoogleId($username);
            }
        }

        $user->setEmail($response->getEmail());
        $user->setFirstname($response->getFirstName());
        $user->setLastname($response->getLastName());

        $this->userManager->updateUser($user);

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    // public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    // {
    //     $userEmail = $response->getEmail();
    //     $user = $this->userManager->findUserByEmail($userEmail);
    //
    //     // if null just create new user and set it properties
    //     if (null === $user) {
    //         $username = $response->getRealName();
    //         $user = new User();
    //         $user->setUsername($username);
    //
    //         // ... save user to database
    //
    //         return $user;
    //     }
    //     // else update access token of existing user
    //     $serviceName = $response->getResourceOwner()->getName();
    //     $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
    //     $user->$setter($response->getAccessToken());//update access token
    //
    //     return $user;
    // }

    public function refreshUser(UserInterface $user)
    {

    }

    public function supportsClass($class) {
        return Account::class === $class;
    }
}
