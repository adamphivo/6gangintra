<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\UserRepository;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment", name="comment")
     */
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    public function newComment(Request $request, UserRepository $userRepo, Post $post)
    {
        $comment = new Comment($post);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $em = $this->getDoctrine()->getManager();
            // a random user is chosen
            $comment->setUser($userRepo->getOneRandomly());
            dd($comment);
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('comment/newComment.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
