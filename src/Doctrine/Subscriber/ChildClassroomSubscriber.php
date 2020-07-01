<?php

namespace App\Doctrine\Subscriber;

use App\Entity\User;
use App\Entity\Child;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ChildClassroomSubscriber implements EventSubscriberInterface
{
    protected Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['setClassroomForChild', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setClassroomForChild(ViewEvent $event)
    {
        /** @var Child */
        $child = $event->getControllerResult();
        $routeName = $event->getRequest()->attributes->get('_route');

        if ($routeName !== "api_children_POST_collection") {
            return;
        }

        /** @var User */
        $user = $this->security->getUser();
        $classroom = $user->getClassroom();

        $child->setClassroom($classroom);
    }
}
