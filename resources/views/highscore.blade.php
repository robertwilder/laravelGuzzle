@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">High Scores</div>

                <h2>Top Players</h2>

                @foreach ($scores as $score)
                    <h3 >{{ $loop->iteration }}.</h3>
                    
                    <p>{{$score->userName}}         -         {{$score->userScore}}</p>
                    
                @endforeach
                
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection