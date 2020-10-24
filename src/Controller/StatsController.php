<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\PostRepository;

class StatsController extends AbstractController
{
    public function displayLeaderBoard(PostRepository $postRepo, UserRepository $userRepo): Response
    {
        return $this->render('stats/leaderboard.html.twig', [
            'leaderBoard' => $userRepo->getLeaderBoard(),
        ]);
    }
}
