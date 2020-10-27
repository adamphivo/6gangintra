<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RandomQuoteController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function randomQuote(): Response
    {
        $response = $this->client->request(
            'GET',
            'https://api.adviceslip.com/advice'
        );

        $content = $response->getContent();

        // Decoding the response as an object we can use
        $content = json_decode($content);

        return new Response(
            '<p>"'.strval($content->slip->advice).'"</p>'
        );
    }
}
