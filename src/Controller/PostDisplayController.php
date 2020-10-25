<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;


class PostDisplayController extends AbstractController
{
    // Render a single post, semi-extensive
    public function displayRandomPost(PostRepository $postRepo, CommentRepository $commentRepo): Response
    {
        $post = $postRepo->getOneRandomly();
        $comments = $commentRepo->findCommentsByPostId($post->getId());
        return $this->render('post_display/randomPost.html.twig', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    // List Controle

    // Render all posts sorted by newest first

    /**
     * @Route("/posts", name="latest_spots")
     */
    public function displayAsList(PostRepository $postRepo, CommentRepository $commentRepo)
    {
        $posts = $postRepo->getAll();
        return $this->render('post_display/list.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/posts/{id}", name="full_post")
     */
    public function displaySpecificArticle(PostRepository $postRepo, CommentRepository $commentRepo, int $id)
    {
        $post = $postRepo->getById($id);
        $comments = $commentRepo->findCommentsByPostId($post->getId());
        dump($post);
        return $this->render('post_display/fullPost.html.twig', [
            'comments' => $comments,
            'post' => $post,
        ]);
    }

    public function lastFive(PostRepository $postRepo, CommentRepository $commentRepo)
    {
        $posts = $postRepo->getLasts(3);
        return $this->render('post_display/listModule.html.twig', [
            'posts' => $posts,
        ]);
    }
}
