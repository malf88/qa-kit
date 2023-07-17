<?php


use Illuminate\Support\Facades\Route;
use App\Modules\GestaoProjetos\Controllers\GantController;


Route::get('/',[GantController::class,'index'])->name('gestao-projetos.index');





