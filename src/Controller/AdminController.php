<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin/", name="admin")
     */
    public function index() : Response
    {
        return $this->render('admin/index.html.twig', [
            'data' => 'data',
        ]);
    }

    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function users(UserRepository $userRepo): Response
    {
        return $this->render('admin/users.html.twig', [
            'users' => $userRepo->findAll(),
        ]);
    }

    /**
     * @Route("/admin/posts", name="admin_posts")
     */
    public function posts(PostRepository $postRepo): Response
    {
        return $this->render('admin/posts.html.twig',[
            'posts' => $postRepo->findAll(),
        ]);
    }

    /**
     * @Route("/admin/comments", name="admin_comments")
     */
    public function comments(CommentRepository $commentRepo): Response
    {
        return $this->render('admin/comments.html.twig',[
            'comments' => $commentRepo->findAll(),
        ]);
    }
}
