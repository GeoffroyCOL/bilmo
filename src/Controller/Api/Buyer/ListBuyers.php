<?php

/**
 * Retrieve list of buyers by customer
 */

namespace App\Controller\Api\Buyer;

use App\Service\BuyerHandler;
use Symfony\Component\Security\Core\Security;

class ListBuyers
{
    private $buyerHandler;
    private $security;

    public function __construct(BuyerHandler $buyerHandler, Security $security)
    {
        $this->buyerHandler = $buyerHandler;
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
