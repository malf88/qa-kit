<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('integracoes.integracoes_projetos', function (Blueprint $table) {
            $table->id();
            $table->string('id_externo');
            $table->bigInteger('projeto_id');
            $table->text('retorno');
            $table->foreign('projeto_id')->on('projetos.projetos')->references('id');


            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('integracoes.integracoes_tarefas', function (Blueprint $table) {
            $table->id();
            $table->string('id_externo');
            $table->bigInteger('tarefa_id');
            $table->text('retorno');
            $table->foreign('tarefa_id')->on('gestao_projetos.tarefas')->references('id');


            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('integracoes.integracoes_sprints', function (Blueprint $table) {
            $table->id();
            $table->string('id_externo');
            $table->bigInteger('sprint_id');
            $table->text('retorno');
            $table->foreign('sprint_id')->on('gestao_projetos.sprints')->references('id');


            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
