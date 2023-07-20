<?php


use Illuminate\Support\Facades\Route;
use App\Modules\GestaoProjetos\Controllers\GantController;
use App\Modules\GestaoProjetos\Controllers\ProjetoController;


Route::get('/',[ProjetoController::class,'index'])->name('gestao-projetos.projetos.index');

//Route::get('/',[GantController::class,'index'])->name('gestao-projetos.index');





