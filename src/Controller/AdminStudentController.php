<?php

namespace App\Controller;

use App\Entity\Child;
use App\Form\ChildType;
use App\Repository\ChildRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminStudentController extends AbstractController
{
    /**
     * @Route("/admin/student", name="admin_student_index")
     */
    public function index(ChildRepository $childRepository)
    {
        $students = $childRepository->findAll();

        return $this->render('admin_student/index.html.twig', [
            'students' => $students
        ]);
    }

    /**
     * @Route("admin/student/{id<\d+>}/edit", name="admin_student_edit")
     */
    public function edit(Request $request, Child $child, EntityManagerInterface $entityManagerInterface)
    {
        $form = $this->createForm(ChildType::class, $child);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->flush();
            return $this->redirectToRoute("admin_student_index");
        }

        return $this->render("admin_student/edit.html.twig", [
            'studentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/student/{id<\d+>}/delete", name="admin_student_delete")
     */
    public function delete(Child $child, EntityManagerInterface $entityManagerInterface)
    {
        $entityManagerInterface->remove($child);
        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_student_index");
    }
}
