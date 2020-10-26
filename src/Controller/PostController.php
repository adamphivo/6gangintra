<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use App\Repository\CategoryRepository;
use App\Form\PostType;


class PostController extends AbstractController
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

    // Render X lasts post as a list module
    public function lastFive(PostRepository $postRepo, CommentRepository $commentRepo)
    {
        $posts = $postRepo->getLasts(3);
        return $this->render('post_display/listModule.html.twig', [
            'posts' => $posts,
            'sectionName' => "Latest posts"
        ]);
    }

    // Render all posts sorted by newest first
    /**
     * @Route("/posts", name="latest_spots")
     */
    public function displayAsList(PostRepository $postRepo, CommentRepository $commentRepo)
    {
        $posts = $postRepo->getAll();
        return $this->render('post_display/list.html.twig', [
            'posts' => $posts,
            'sectionName' => 'All posts'
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

    /**
     * @Route("/posts/category/{categoryName}", name="category_post")
    */
    public function byCategory(PostRepository $postRepo, CategoryRepository $categoryRepo, string $categoryName)
    {   
        $category = $categoryRepo->findOneBy(['name' => $categoryName]);
        return $this->render('post_display/list.html.twig', [
            'posts' => $category->getPosts(),
            'sectionName' => $categoryName
        ]);
    }
}
