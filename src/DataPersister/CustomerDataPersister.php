<?php

namespace App\DataPersister;

use App\Entity\User;
use App\Entity\Customer;
use App\Service\UserHandler;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class CustomerDataPersister implements DataPersisterInterface
{
    private $userHandler;

    public function __construct(UserHandler $userHandler)
    {
        $this->userHandler = $userHandler;
    }
    
    /**
     * supports
     *
     * @param  User $data
     * @param  mixed $context
     * @return bool
     */
    public function supports($data): bool
    {
        return $data instanceof Customer;
    }
        
    /**
     * persist
     *
     * @param  Customer $data
     * @param  array $context
     */
    public function persist($data, array $context = [])
    {
        return $this->userHandler->add($data);
    }
    
    /**
     * remove
     *
     * @param  Customer $data
     * @param  array $context
     */
    public function remove($data)
    {
        $this->userHandler->delete($data);
    }
}
