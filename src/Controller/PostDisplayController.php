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

    // Render all posts sorted by newest first
    /**
     * @Route("/posts/latestsposts", name="latest_spots")
     */
    public function displayLastsPost(PostRepository $postRepo, CommentRepository $commentRepo)
    {
        $posts = $postRepo->getAll();
        return $this->render('post_display/list.html.twig', [
            'latestPosts' => $posts,
        ]);
    }
}
