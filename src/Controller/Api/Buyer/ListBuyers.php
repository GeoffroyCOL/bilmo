<?php

/**
 * Retrieve list of buyers by customer
 */

namespace App\Controller\Api\Buyer;

use Symfony\Component\Security\Core\Security;

class ListBuyers
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
        return $data->getBuyers();
    }
}
