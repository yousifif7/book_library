<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BooksController;

Route::get('/', function () {
    return view('welcome');
});

// viewing main page when logged in
Route::get('/index', [UserController::class, 'index'])->middleware('auth');

// storing user to db
Route::post('/user/register',[UserController::class ,'store'])->middleware('auth');

//log user in
route::post('/user/login',[UserController::class, 'login'])->middleware('guest');

//logout a user
route::get('/user/logout',[UserController::class, 'logout'])->middleware('auth');

//create book
route::post('/book/store', [BooksController::class, 'store'])->middleware('auth');

//delete a book
route::delete('/book/delete/{id}',[BooksController::class, 'destroy'])->middleware('auth');

// show update book page
route::get('/book/edit/{id}', [BooksController::class, 'edit'])->middleware('auth');

//update data of a book
route::put('/book/update/{book}', [BooksController::class, 'update'])->middleware('auth');