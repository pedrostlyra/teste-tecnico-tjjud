<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LivroController;
use App\Http\Controllers\Api\AutorController;
use App\Http\Controllers\Api\AssuntoController;

Route::apiResource('livros', LivroController::class);
Route::apiResource('autor', AutorController::class);
Route::apiResource('assunto', AssuntoController::class);
