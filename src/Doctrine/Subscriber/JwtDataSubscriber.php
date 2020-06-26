<?php

namespace App\Doctrine\Subscriber;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JwtDataSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::JWT_CREATED => 'addFullName'
        ];
    }

    public function addFullName(JWTCreatedEvent $event)
    {
        /** @var User */
        $user = $event->getUser();
        $data = $event->getData();

        $data['firstName'] = $user->getFirstName();
        $data['lastName'] = $user->getLastName();

        $event->setData($data);
    }
}
