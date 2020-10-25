<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;

class NavigationBarController extends AbstractController
{
    public function index(CategoryRepository $categoryRepo): Response
    {
        return $this->render('navigation_bar/index.html.twig', [
            'categories' => $categoryRepo->findAll(),
        ]);
    }
}
