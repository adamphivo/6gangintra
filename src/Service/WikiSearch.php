<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WikiSearch 
{

    private $client;

    public function __construct(HttpClientInterface $client) 
    {
        $this->client = $client;
    }

    public function search(string $searchString)
    {

        $requestString = <<<URL
        https://en.wikipedia.org/w/api.php?action=opensearch&format=json&search=$searchString&namespace=0&limit=10
        URL;

        $reponse = $this->client->request(
            'GET',
            $requestString
        );

        $content = $reponse->getContent();
        $content = json_decode($content);

        // Return the content
        return $this->parseResponse($content);
    }

    public function parseResponse($content)
    {
        $parsedContent = Array();

        for($i = 0; $i < count($content[1]); $i ++) {
            array_push($parsedContent, [$content[1][$i] => $content[3][$i]]);
        }
        return $parsedContent;
    }
}