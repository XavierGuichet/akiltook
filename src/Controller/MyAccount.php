<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Account;
use Doctrine\Common\Persistence\ManagerRegistry;

class MyAccount
{
    /**
     * @Route(
     *     name="my_account",
     *     path="/accounts/{id}",
     *     defaults={"_api_resource_class"=Account::class, "_api_item_operation_name"="my_account"}
     * )
     * @return Account|null
     */
    public function __invoke($data)
    {
        // Return the User object
        return $data;
    }
}