<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Entity\Category;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;

class CategoryController extends AbstractController
{
    // Render categories as stamps
    public function stamps(CategoryRepository $categoryRepo, Post $post): Response
    {
        return $this->render('category/stamps.html.twig', [
            'post' => $post,
            'categories' => $categoryRepo->findByPost($post->getId()),
        ]);
    }
}
