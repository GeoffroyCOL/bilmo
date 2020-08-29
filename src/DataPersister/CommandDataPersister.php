<?php

namespace App\DataPersister;

use App\Entity\Command;
use App\Service\BuyerHandler;
use App\Service\CommandHandler;
use App\Service\CustomerHandler;
use App\Service\LineCommandHandler;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class CommandDataPersister implements DataPersisterInterface
{
    private $commandHandler;
    private $buyerHandler;
    private $lineCommandHandler;
    private $customerHandler;

    public function __construct(
        CommandHandler $commandHandler,
        BuyerHandler $buyerHandler,
        LineCommandHandler $lineCommandHandler
    ) {
        $this->commandHandler = $commandHandler;
        $this->buyerHandler = $buyerHandler;
        $this->lineCommandHandler = $lineCommandHandler;
    }
    
    /**
     * supports
     *
     * @param  Command $data
     * @param  array $context
     * @return bool
     */
    public function supports($data): bool
    {
        return $data instanceof Command;
    }
        
    /**
     * persist
     *
     * @param  Comment $data
     * @param  array $context
     * @return Command
     */
    public function persist($data): Command
    {
        //Check if buyer is already registed
        $buyer = $this->buyerHandler->getBuyer([
            'firstName' => $data->getBuyer()->getFirstName(),
            'lastName' => $data->getBuyer()->getLastName(),
        ]);

        if ($buyer) {
            $data->setBuyer($buyer);
        }

        return $this->commandHandler->add($data);
    }
    
    /**
     * remove
     *
     * @param  command $data
     * @param  array $context
     */
    public function remove($data)
    {
        $this->commandHandler->delete($data);
    }
}
