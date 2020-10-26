<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Entity\Post;
use App\Entity\Category;
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
     * @Route("/posts/{id}", name="full_post", requirements={"id"="\d+"})
     */
    public function displaySpecificArticle(PostRepository $postRepo, CommentRepository $commentRepo, int $id)
    {
        $post = $postRepo->getById($id);
        $comments = $commentRepo->findCommentsByPostId($post->getId());
        return $this->render('post_display/fullPost.html.twig', [
            'comments' => $comments,
            'post' => $post,
            'categories' => $post->getCategories(),
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

    /**
     * @Route("/posts/new", name="post_new")
     */
    public function newPost(Request $request, UserRepository $userRepo)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $em = $this->getDoctrine()->getManager();

            // a random user is chosen
            $post->setUser($userRepo->getOneRandomly());
            
            $test = Array();
            foreach($post->getCategories() as $category){
                $test[] = $category->__toString();
            }

            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('post_display/newPost.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
