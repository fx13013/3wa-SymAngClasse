<?php

namespace App\Doctrine\Subscriber;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class JwtDataSubscriber implements EventSubscriberInterface
{
    protected Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::JWT_CREATED => 'addFullName'
        ];
    }

    public function addFullName(JWTCreatedEvent $event)
    {
        if ($this->security->isGranted('ROLE_PROF')) {
            /** @var User */
            $user = $event->getUser();
            $data = $event->getData();
            $classroom = $user->getClassroom()->getId();

            $data['firstName'] = $user->getFirstName();
            $data['lastName'] = $user->getLastName();
            $data['classroom'] = $classroom;

            $event->setData($data);
        }
    }
}
