<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\WikiSearch;
use App\Service\StackOverflowSearch;

class SearchController extends AbstractController
{
    public function searchWiki(WikiSearch $wikiSearch, string $searchString): Response
    {
        return $this->render('search/api_results.html.twig', [
            'results' => $wikiSearch->search($searchString),
            'title' => 'wikipedia'
        ]);
    }

    public function searchStack(StackOverflowSearch $stackSearch, string $searchString) : Response
    {
        return $this->render('search/api_results.html.twig', [
            'results' => $stackSearch->search($searchString),
            'title' => 'stackoverflow'
        ]);
    }
}
