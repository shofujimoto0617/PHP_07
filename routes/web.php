<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Models\User;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    echo " This is Home page ";
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contactsd-asdf-asdfasd', [ContactController::class, 'index'])->name('ariyan');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

    $users = User::all();
    return view('dashboard',compact('users'));
})->name('dashboard');
