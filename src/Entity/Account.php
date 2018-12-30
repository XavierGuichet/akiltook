<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Account
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"account", "account:read"}},
 *     denormalizationContext={"groups"={"account", "account:write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 */
class Account implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @Groups({"account"})
     * @ORM\Column(type="string", length=190, unique=true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $roles;

    /**
     * @var string
     *
     * @Groups({"account:write"})
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    public function __construct() {
        $this->setRoles(array("ROLE_USER"));
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        $this->setUsername($this->email);

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set roles
     *
     * @param array||string $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        if (!is_array($roles) && is_string($roles)) {
            $roles = array($roles);
        }
        $this->roles = serialize($roles);

        return $this;
    }

    /**
     * Get roles
     *
     * @return string
     */
    public function getRoles()
    {
        return unserialize($this->roles);
    }

    /**
     * Add roles
     *
     * @return string
     */
    public function addRoles($roles)
    {
        $arr_roles = $this->getRoles();
        $arr_roles[] = $roles;
        $arr_roles = array_unique($arr_roles);
        sort($arr_roles);
        $this->setRoles($arr_roles);

        return unserialize($this->roles);
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials() {

    }
}
