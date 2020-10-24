<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavigationBarController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('navigation_bar/index.html.twig', [
            'controller_name' => 'NavigationBarController',
        ]);
    }
}
