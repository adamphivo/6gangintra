<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;

class PostDisplayController extends AbstractController
{
    public function displayRandomPost(PostRepository $postRepo): Response
    {

        return $this->render('randomPost/thumbnails.html.twig', [
            'post' => $postRepo->getOneRandomly(),
        ]);
    }
}
