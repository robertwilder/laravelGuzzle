<?php

namespace App\Http\Controllers;

use App\Score;

use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function store(Request $request)
    {
        

        $post = Score::create($request->all());
        $post->userScore = request('userScore');
        $post->userName = request('userName');
        $post->scoreInt = request('scoreInt');

        response()->json($post);
        
        // echo "inside score controller";
        
        // dd($request);
        // Score::create($request->All());
    }
}
