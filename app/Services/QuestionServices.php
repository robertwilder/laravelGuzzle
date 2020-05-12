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
        

        $response = $this->client->get('/api.php?amount=10');


        $body = json_decode((string) $response->getBody(), true);

        
        $collection = collect($body['results'])->map(function ($question){
            return [
                'category' => $question['category'],
                'type' => $question['type'],
                'difficulty' => $question['difficulty'],
                'question' => $question['question'],
                'correct_answer' => $question['correct_answer'],
                'incorrect_answers' => $question['incorrect_answers']
            ];

        });

        return $collection;

    }

}