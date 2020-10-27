<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class StackOverflowSearch
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function search(string $searchString)
    {
        $requestString = <<<URL
        https://api.stackexchange.com/2.2/search?order=desc&sort=activity&intitle=$searchString&site=stackoverflow
        URL;

        $reponse = $this->client->request(
            'GET',
            $requestString
        );

        $content = $reponse->getContent();
        $content = json_decode($content);

        return $this->parseResponse($content);
    }

    public function parseResponse($content)
    {
        $parsedContent = Array();

        foreach($content->items as $item)
        {
            array_push($parsedContent, [$item->title => $item->link]);
        }

        return $parsedContent;
    }
}