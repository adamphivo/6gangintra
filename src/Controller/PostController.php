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
use App\Repository\SearchRepository;
use App\Entity\Post;
use App\Entity\Search;
use App\Entity\Comment;
use App\Entity\Category;
use App\Form\PostType;

use App\Form\CommentType;



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
            'sectionName' => "Recent"
        ]);
    }
    
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
    public function displaySpecificArticle(Request $request, PostRepository $postRepo, CommentRepository $commentRepo, UserRepository $userRepo, int $id)
    {
        $post = $postRepo->getById($id);
        $comments = $commentRepo->findCommentsByPostId($post->getId());

        // Add a new comment Form
        $comment = new Comment($post);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $em = $this->getDoctrine()->getManager();
            // a random user is chosen
            $comment->setUser($userRepo->getOneRandomly());
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('full_post', array('id' => $id));
        }

        // Render
        return $this->render('post_display/fullPost.html.twig', [
            'comments' => $comments,
            'post' => $post,
            'categories' => $post->getCategories(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/posts/category/{categoryName}", name="category_post", requirements={"categoryName"="\w+"})
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
        // Add a new article form
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $em = $this->getDoctrine()->getManager();

            // a random user is chosen
            $post->setUser($userRepo->getOneRandomly());
            
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('post_display/newPost.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/posts/search/", name="post_search")
     */
    public function search(Request $request, 
                           PostRepository $postRepo, 
                           SearchRepository $searchRepo)

    {

        $em = $this->getDoctrine()->getManager();

        // treat the search as words
        foreach(explode(' ', $request->query->get('say')) as $word) {
            // filtering the input for database
            $existingSearch = $searchRepo->findOneBy(['searchContent' => $word]);
            if($existingSearch) {
                $currentCount = $existingSearch->getCount();
                $existingSearch->setCount($currentCount + 1);
                $em->persist($existingSearch);
                $em->flush();
            } else {
                $search = new Search();
                $search->setSearchContent($word);
                $em->persist($search);
                $em->flush();
            }
        }

        return $this->render('post_display/list.html.twig', [
            'query' => $request->query->get('say'),
            'posts' => $postRepo->findByString($request->query->get('say')),
            'sectionName' => $request->query->get('say')
        ]);
    }
}
