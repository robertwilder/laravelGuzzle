@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1>Welcome {{auth::user()->name}}</h1>

                    <h2>Pick your quiz:</h2>

                    <a href="/quiz" type="button" class="btn btn-primary btn-lg btn-block">Random</a>
                    <button type="button" class="btn btn-primary btn-lg btn-block">General Knowledge</button>
                    <button type="button" class="btn btn-primary btn-lg btn-block">Books</button>
                    <button type="button" class="btn btn-primary btn-lg btn-block">Music</button>
                    <button type="button" class="btn btn-primary btn-lg btn-block">Television</button>
                    

                
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
