<?php

/**
 * When user connected
 */

namespace App\Listener;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListener
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * onSecurityInteractivelogin
     *
     * @param  InteractiveLoginEvent $event
     * @return void
     */
    public function onSecurityInteractivelogin(InteractiveLoginEvent $event)
    {
        //Get user when login
        $user = $event->getAuthenticationToken()->getUser();

        //update connect date
        $user->setConnectedAt(new \DateTime());

        $this->manager->persist($user);
        $this->manager->flush();
    }
}
