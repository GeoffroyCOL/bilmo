<?php

/**
 * Retrieve list of commands by customer
 */

namespace App\Controller\Api\Command;

use Symfony\Component\Security\Core\Security;

class ListCommands
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    /**
     * __invoke
     *
     * @param  Customer $data
     * @return Commands
     */
    public function __invoke($data)
    {
        $customer = $this->security->getUser();
        return $data->getCommands();
    }
}
