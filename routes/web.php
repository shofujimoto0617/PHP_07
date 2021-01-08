<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    echo " This is Home page ";
});

Route::get('/about', function () {
    return view('about');
})->middleware('check');

Route::get('/contact', [ContactController::class, 'index']);
