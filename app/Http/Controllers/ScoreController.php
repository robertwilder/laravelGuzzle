<?php

namespace App\Http\Controllers;

use App\Score;

use Illuminate\Http\Request;

class ScoreController extends Controller
{

    public function index(Request $request){


        $scores = Score::all();

        return view('highscore', ['scores' => $scores]);
    }


    public function store(Request $request)
    {
        

        $post = Score::create($request->all());
        $post->userScore = request('userScore');
        $post->userName = request('userName');
        $post->scoreInt = request('scoreInt');
        
        response()->json($post);
        
        $post->save();
        // echo "inside score controller";
        
        // dd($request);
        // Score::create($request->All());

        return redirect('/home');
    }
}
