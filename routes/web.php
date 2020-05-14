<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/quiz', function () {
    return view('quiz');
})->middleware('auth');

Route::get('/thequiz', function () {
    return view('singleq');
});

Route::get('questions', 'QuestionsController')->name('questions');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
