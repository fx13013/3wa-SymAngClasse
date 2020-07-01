<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Message;
use App\Form\ClassroomType;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminMessageController extends AbstractController
{
    /**
     * @Route("/admin/message", name="admin_message_index")
     */
    public function index(MessageRepository $messageRepository)
    {
        $messages = $messageRepository->findAll();

        return $this->render('admin_message/index.html.twig', [
            'messages' => $messages
        ]);
    }

    /**
     * @Route("admin/message/{id<\d+>}/edit", name="admin_message_edit")
     */
    public function edit(Request $request, Message $message, EntityManagerInterface $entityManagerInterface)
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->flush();
            return $this->redirectToRoute('admin_message_index');
        }

        return $this->render('admin_message/edit.html.twig', [
            'messageForm' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/message/{id<\d+>}/delete", name="admin_message_delete")
     */
    public function delete(Message $message, EntityManagerInterface $entityManagerInterface)
    {
        $entityManagerInterface->remove($message);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('admin_message_index');
    }
}
