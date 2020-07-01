<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminAnnonceController extends AbstractController
{
    /**
     * @Route("/admin/annonce", name="admin_annonce_index")
     */
    public function index(AnnonceRepository $annonceRepository)
    {
        $annonces = $annonceRepository->findAll();

        return $this->render('admin_annonce/index.html.twig', [
            'annonces' => $annonces
        ]);
    }

    /**
     * @Route("admin/annonce/{id<\d+>}/edit", name="admin_annonce_edit")
     */
    public function edit(Request $request, Annonce $annonce, EntityManagerInterface $entityManagerInterface)
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->flush();
            return $this->redirectToRoute('admin_annonce_index');
        }

        return $this->render('admin_annonce/edit.html.twig', [
            'annonceForm' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/annonce/{id<\d+>}/delete", name="admin_annonce_delete")
     */
    public function delete(Annonce $annonce, EntityManagerInterface $entityManagerInterface)
    {
        $entityManagerInterface->remove($annonce);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('admin_annonce_index');
    }
}
