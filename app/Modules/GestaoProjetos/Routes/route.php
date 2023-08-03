<?php


use Illuminate\Support\Facades\Route;
use App\Modules\GestaoProjetos\Controllers\GantController;
use App\Modules\GestaoProjetos\Controllers\ProjetoController;
use App\Modules\GestaoProjetos\Controllers\TarefaController;
Route::group(['prefix' => ''],function () {
    Route::get('/', [ProjetoController::class, 'index'])->name('gestao-projetos.projetos.index');


    Route::group(['prefix' => '{idProjeto}/tarefas'],function (){

    });
    Route::group(['prefix' => '/tarefas'],function (){
        Route::post('tarefas/salvar', [TarefaController::class, 'salvar'])->name('gestao-projetos.tarefas.salvar');
    });
});

//Route::get('/',[GantController::class,'index'])->name('gestao-projetos.index');





