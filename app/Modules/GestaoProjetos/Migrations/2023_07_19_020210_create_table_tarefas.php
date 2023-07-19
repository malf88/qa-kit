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
        Schema::create('gestao_projetos.sprints', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->date('inicio');
            $table->date('termino');
            $table->bigInteger('projeto_id');
            $table->foreign('projeto_id')->on('projetos.projetos')->references('id');


            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('gestao_projetos.tarefas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->longText('descricao')->nullable();
            $table->enum('status', [
                'Aberta',
                'Em desenvolvimento',
                'Em auditoria',
                'Em publicação',
                'Cancelada',
                'Concluída',
                'Arquivada'
            ])->default('Aberta');
            $table->timestamp('data_arquivamento')->nullable();
            $table->date('inicio_estimado')->nullable();
            $table->date('termino_estimado')->nullable();
            $table->bigInteger('projeto_id');
            $table->bigInteger('responsavel_id')->nullable();
            $table->bigInteger('sprint_id')->nullable();
            $table->foreign('responsavel_id')->on('users')->references('id');
            $table->foreign('projeto_id')->on('projetos.projetos')->references('id');
            $table->foreign('sprint_id')->on('gestao_projetos.sprints')->references('id');

            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('gestao_projetos.comentarios_tarefa', function (Blueprint $table) {
            $table->id();

            $table->longText('descricao')->nullable();
            $table->bigInteger('tarefa_id');
            $table->bigInteger('user_id');

            $table->foreign('tarefa_id')->on('gestao_projetos.tarefas')->references('id');
            $table->foreign('user_id')->on('users')->references('id');


            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('gestao_projetos.auditorias_tarefa', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_registro', [
                'INICIO',
                'TERMINO',
                'MOVIMENTACAO'
            ]);
            $table->longText('descricao');
            $table->bigInteger('tarefa_id');
            $table->bigInteger('user_id');

            $table->foreign('tarefa_id')->on('gestao_projetos.tarefas')->references('id');
            $table->foreign('user_id')->on('users')->references('id');


            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('gestao_projetos.casos_teste_tarefas', function (Blueprint $table) {

            $table->bigInteger('caso_teste_id');
            $table->bigInteger('tarefa_id');

            $table->foreign('tarefa_id')->on('gestao_projetos.tarefas')->references('id');
            $table->foreign('caso_teste_id')->on('projetos.casos_teste')->references('id');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_tarefas');
    }
};
