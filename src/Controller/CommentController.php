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
use App\Repository\CommentRepository;

class CommentController extends AbstractController
{
    /**
     * @Route("/comments", name="comment")
     */
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    /**
     * @Route("/comments/delete/{id}", name="comment_delete")
     */
    public function deletePost(CommentRepository $commentRepo ,int $id) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($commentRepo->find($id));
        $em->flush();
        return $this->redirectToRoute('admin_comments');
    }
}
