<?php

namespace App\EventSubscriber;

use App\Entity\Command;
use App\Exception\BadNumberException;
use App\Exception\PhoneAvailableException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class CommandManager implements EventSubscriberInterface
{
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    /**
     * getSubscribedEvents
     *
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['checkCommandAvailability', EventPriorities::PRE_VALIDATE],
        ];
    }
    
    /**
     * checkLineCommandAvailability
     *
     * @param  ViewEvent $event
     * @return void
     */
    public function checkCommandAvailability(ViewEvent $event): void
    {
        //Only for Post method and Command Object
        $method = $this->request->getCurrentRequest()->getMethod();
        if ($method !== "POST" || !$event->getControllerResult() instanceof Command) {
            return;
        }

        $listPhones = [];
        $linesCommand = $event->getControllerResult()->getLineCommand()->toArray();

        foreach ($linesCommand as $lineCommand) {
            $numberCommand = $lineCommand->getNumber();
            $restPhone = $lineCommand->getPhone()->getNumber() - $lineCommand->getPhone()->getNumberSold();

            //Check that the number of telephones ordered is strictly greater than 0
            if ($numberCommand > $restPhone) {
                throw new BadNumberException(sprintf('Le nombre de téléphone restant est insuffisant pour cette commande : %d', $lineCommand->getNumber()));
            }

            //Checks if the phone stock is sufficient for the order and if the sale status is active
            if ($lineCommand->getPhone()->getActive() === false) {
                throw new PhoneAvailableException(sprintf('Le téléphone " %s " n\'est pas disponible pour le moment', $lineCommand->getPhone()->getName()));
            }

            //Check if the phone is already present
            if (in_array($lineCommand->getPhone(), $listPhones)) {
                throw new PhoneAvailableException(sprintf('Le téléphone " %s " est déjà présent dans la commande', $lineCommand->getPhone()->getName()));
            }

            $listPhones[] = $lineCommand->getPhone();
        }
    }
}
