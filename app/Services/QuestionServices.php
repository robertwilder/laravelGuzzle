<?php


namespace App\Services;
use App\Http\Clients\QuestionClient;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;


class QuestionServices

{
    private $client;

    public function __construct(QuestionClient $client)
    {
        $this->client = $client;

    }


    public function category(): Collection
    {
        // retrieve data from api
        // convert data to a collection
        // return collection 
        

        $response = $this->client->get('?limit=10&random=true');

        $body = json_decode((string) $response->getBody(), true);

        $collection = collect($body)->map(function ($question){
            return [
                'category' => $question['category'],
                'question' => $question['question'],
                'answer' => $question['answer'],
                'tags' => $question['tags']
            ];

        });

        return $collection;

    }

}