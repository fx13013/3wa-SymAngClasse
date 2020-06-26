<?php

namespace App\Doctrine\Subscriber;

use App\Entity\Annonce;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AnnonceClassroomSubscriber implements EventSubscriberInterface
{
    protected Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['setClassroomForAnnonce', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setClassroomForAnnonce(ViewEvent $event)
    {
        /** @var Annonce */
        $annonce = $event->getControllerResult();
        $routeName = $event->getRequest()->attributes->get('_route');

        if ($routeName !== "api_annonces_post_collection") {
            return;
        }

        /** @var User */
        $user = $this->security->getUser()->getClassroom();
        $annonce->setClassroom($user);
    }
}
