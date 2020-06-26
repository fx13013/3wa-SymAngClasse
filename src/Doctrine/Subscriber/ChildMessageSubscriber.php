<?php

namespace App\Doctrine\Subscriber;

use App\Entity\User;
use App\Entity\Child;
use App\Entity\Message;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ChildMessageSubscriber implements EventSubscriberInterface
{
    protected Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['setMessageForChild', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setMessageForChild(ViewEvent $event)
    {
        /** @var Message */
        $message = $event->getControllerResult();
        $routeName = $event->getRequest()->attributes->get('_route');

        if ($routeName !== "api_messages_post_collection") {
            return;
        }

        /** @var User */
        $user = $this->security->getUser()->getStudent();
        $message->setChild($user);
    }
}
