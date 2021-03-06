<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="admin_user_index")
     */
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->render('admin_user/index.html.twig', [
            'users' => $users
        ]);
    }
}
