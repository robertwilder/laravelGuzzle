<?php

namespace App\Http\Controllers;

use App\Services\QuestionServices;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, QuestionServices $questions)
    {
        $category = $questions->category();

        return $category;
    }
}
