<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminClassroomController extends AbstractController
{
    /**
     * @Route("/admin/classroom", name="admin_classroom_index")
     */
    public function index(ClassroomRepository $classroomRepository)
    {
        $classes = $classroomRepository->findAll();

        return $this->render('admin_classroom/index.html.twig', [
            'classes' => $classes
        ]);
    }

    /**
     * @Route("/admin/classroom/create", name="admin_classroom_create")
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ClassroomType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classroom = $form->getData();

            $manager->persist($classroom);
            $manager->flush();

            return $this->redirectToRoute('admin_classroom_index');
        }

        return $this->render('admin_classroom/create.html.twig', [
            'classroomForm' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/classroom/{id<\d+>}/edit", name="admin_classroom_edit")
     */
    public function edit(Classroom $classroom, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            return $this->redirectToRoute('admin_classroom_index');
        }

        return $this->render('admin_classroom/edit.html.twig', [
            'classroomForm' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/classroom/{id<\d+>}/delete", name="admin_classroom_delete")
     */
    public function delete(Classroom $classroom, EntityManagerInterface $entityManagerInterface)
    {
        $entityManagerInterface->remove($classroom);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('admin_classroom_index');
    }
}
