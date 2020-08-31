<?php

/**
 * Add the user ID in the paylord when connecting
 */

namespace App\Listener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload       = $event->getData();
        $payload['id'] = $event->getUser()->getId();

        $event->setData($payload);
    }
}
