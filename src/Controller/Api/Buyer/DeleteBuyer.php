<?php

/**
 * Remove either a buyer or the relationship between a buyer and a customer
 */

namespace App\Controller\Api\Buyer;

use App\Service\BuyerHandler;
use Symfony\Component\Security\Core\Security;

class DeleteBuyer
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

        //If the buyer has more than one customer, we only delete the relationship ....
        if (count($data->getCustomers()->toArray()) >= 2) {
            $this->buyerHandler->removeRelationWithCustomer($customer, $data);
            return;
        }

        //.... otherwise we delete the buyer
        return $data;
    }
}
