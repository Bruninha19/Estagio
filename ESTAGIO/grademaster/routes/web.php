<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/criarConta', function () {
    return view('criarConta');
});

Route::post('/cadastrar', [UserController::class, 'criarUsuario']) -> name('cadastrar');
