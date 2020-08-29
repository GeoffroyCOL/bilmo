<?php

namespace App\DataProvider;

use App\Entity\Admin;
use App\Entity\Buyer;
use App\Entity\Customer;
use App\Service\BuyerHandler;
use App\Service\CommandHandler;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class BuyerItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $tokenStorage;
    private $commandHandler;
    private $buyerHandler;

    public function __construct(TokenStorageInterface $tokenStorage, CommandHandler $commandHandler, BuyerHandler $buyerHandler)
    {
        $this->tokenStorage = $tokenStorage;
        $this->commandHandler = $commandHandler;
        $this->buyerHandler = $buyerHandler;
    }
    
    /**
     * supports
     *
     * @param  string $resourceClass
     * @param  string $operationName
     * @param  array $context
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Buyer::class === $resourceClass && $operationName === 'GET' && !in_array("admin:buyer:read", $context['groups']);
    }
    
    /**
     * getItem
     *
     * @param  string $resourceClass
     * @param  int $id
     * @param  string $operationName
     * @param  array $context
     * @return Buyer|null
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?Buyer
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $buyer = $this->buyerHandler->getBuyer(['id' => $id]);

        //Recovers buyer's orders according to customer
        if ($user instanceof Customer && $user !== null) {
            $commands = $this->commandHandler->getCommandForBuyerByCustomer($buyer, $user);
        }

        //If commands exist
        
        $buyer->setCommandsByCustomer($commands);
        

        return $buyer;
    }
}
