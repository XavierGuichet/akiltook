<?php

namespace App\Provider;

use App\Entity\Account;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Repository\AccountRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class AccountItemProvider implements ItemDataProviderInterface
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * UserMe constructor.
     *
     * @param UserRepository $repository
     * @param TokenStorage   $tokenStorage
     */
    public function __construct(AccountRepository $repository, TokenStorageInterface $tokenStorage)
    {
        $this->repository   = $repository;
        $this->tokenStorage = $tokenStorage;
    }
    
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Account::class === $resourceClass;
    }

    /**
     * @param string      $resourceClass
     * @param int|string  $id
     * @param string|null $operationName
     * @param array       $context
     *
     * @return Account|null
     * @throws ResourceClassNotSupportedException
     */    
    public function getItem(string $resourceClass, $id = null, string $operationName = null, array $context = []): ?Account
    {
        if (Account::class !== $resourceClass) {
            throw new ResourceClassNotSupportedException();
        }

        // retrieves User from the security when no id
        if (0 === $id) {
            return $this->tokenStorage->getToken()->getUser();
        }
        return $this->repository->find($id); // Retrieves User normally for other actions
    }
}