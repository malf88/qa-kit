<?php


use App\Modules\GestaoProjetos\Controllers\UploadTarefaController;
use Illuminate\Support\Facades\Route;
use App\Modules\GestaoProjetos\Controllers\ProjetoController;
use App\Modules\GestaoProjetos\Controllers\TarefaController;
Route::group(['prefix' => ''],function () {
    Route::get('/', [ProjetoController::class, 'index'])->name('gestao-projetos.projetos.index');
    Route::group(['prefix' => '{idProjeto}/tarefas'],function (){
        Route::get('/',[TarefaController::class,'tarefas'])->name('gestao-projetos.projetos.tarefas.index');
        Route::post('/',[TarefaController::class,'updateTarefa'])->name('gestao-projetos.projetos.tarefas.update');
        Route::post('/upload',[UploadTarefaController::class,'uploadTarefa'])->name('gestao-projetos.projetos.tarefas.upload');

    });
    Route::group(['prefix' => '/tarefas'],function (){
        Route::post('salvar', [TarefaController::class, 'salvar'])->name('gestao-projetos.tarefas.salvar');
    });
});

//Route::get('/',[GantController::class,'index'])->name('gestao-projetos.index');





