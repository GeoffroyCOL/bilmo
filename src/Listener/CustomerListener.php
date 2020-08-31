<?php

namespace App\Listener;

use App\Entity\Customer;
use App\Service\BuyerHandler;
use App\Service\CustomerHandler;

class CustomerListener
{
    private $customerHandler;
    private $buyerHandler;

    public function __construct(CustomerHandler $customerHandler, BuyerHandler $buyerHandler)
    {
        $this->customerHandler = $customerHandler;
        $this->buyerHandler = $buyerHandler;
    }

    public function preRemove(Customer $customer)
    {
        foreach ($customer->getBuyers()->toArray() as $buyer) {
            if ($buyer->getCustomers()->count() == 1) {
                $this->buyerHandler->delete($buyer);
            }
        }
    }
}
