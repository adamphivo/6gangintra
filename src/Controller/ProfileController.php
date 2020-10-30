<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="profile")
     */
    public function index(UserRepository $userRepo, int $id): Response
    {
        return $this->render('profile/index.html.twig', [
            'user' => $userRepo->find($id),
        ]);
    }
}
