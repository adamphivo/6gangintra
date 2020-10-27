<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\WikiSearch;

class WikipediaSearchController extends AbstractController
{
    public function index(WikiSearch $searchEngine, string $searchString): Response
    {
        return $this->render('wikipedia_search/index.html.twig', [
            'results' => $searchEngine->search($searchString),
        ]);
    }
}
