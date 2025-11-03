<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\AssuntoController;
use App\Http\Controllers\RelatorioController;

Route::get('/', function () {
    return redirect()->route('livros.index');
});

Route::resource('livros', LivroController::class);
Route::resource('autores', AutorController::class)->parameters(['autores' => 'autor']);
Route::resource('assuntos', AssuntoController::class);

Route::get('relatorio', [RelatorioController::class, 'index'])->name('relatorio.index');
Route::get('relatorio/gerar', [RelatorioController::class, 'gerar'])->name('relatorio.gerar');
Route::get('relatorio/xml', [RelatorioController::class, 'exportXml'])->name('relatorio.xml');
Route::get('relatorio/json', [RelatorioController::class, 'exportJson'])->name('relatorio.json');