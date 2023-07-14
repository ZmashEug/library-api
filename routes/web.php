<?php

use Illuminate\Support\Facades\Route;

// Авторизация
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

// Книги
Route::get('/books', 'BookController@index');
Route::get('/books', 'BookController@show');

// Администраторские функции
Route::post('/books', 'BookController@store');
Route::delete('/books', 'BookController@destroy');
Route::get('/books/export', 'BookController@export');

// Клиентские функции
Route::post('/users/favorite', 'UserController@addToFavorites');
Route::delete('/users/favorite', 'UserController@removeFromFavorites');