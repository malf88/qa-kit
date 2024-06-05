<?php

use App\Modules\QAraCasosTeste\Controllers\QAraController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/casos-teste'],function() {
    Route::group(['prefix' => '/'],function() {
        Route::get('/', [QAraController::class, 'index'])->name('caso-teste.qara.index');
        Route::post('/gerar-texto', [QAraController::class, 'gerarTexto'])->name('caso-teste.qara.gerar-texto');
    });

});


