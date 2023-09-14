<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Permission::create(['name' => 'LISTAR_TAREFA']);
        Permission::create(['name' => 'REMOVER_TAREFA']);
        Permission::create(['name' => 'INSERIR_TAREFA']);
        Permission::create(['name' => 'ALTERAR_TAREFA']);
        Permission::create(['name' => 'ARQUIVAR_TAREFA']);
        Permission::create(['name' => 'EXPORTAR_PROJETO_TRELLO']);

        Permission::create(['name' => 'INSERIR_OBSERVACAO_TAREFA']);

        Permission::create(['name' => 'VER_KANBAN']);
        Permission::create(['name' => 'VER_GANTT']);
        Permission::create(['name' => 'PODE_ALTERAR_TAREFA_CONCLUIDA']);

        $roleAdministrador = Role::findByName('ADMINISTRADOR');
        $roleAdministrador->syncPermissions(Permission::all());

        $roleAuditor = Role::findByName('AUDITOR');
        $roleAuditor->givePermissionTo([
                'LISTAR_TAREFA',
                'REMOVER_TAREFA',
                'INSERIR_TAREFA',
                'ALTERAR_TAREFA',
                'ARQUIVAR_TAREFA',
                'VER_KANBAN',
                'INSERIR_OBSERVACAO_TAREFA'
            ]);
        $roleGestor = Role::findByName('GESTOR');
        $roleGestor->givePermissionTo([
                'LISTAR_TAREFA',
                'REMOVER_TAREFA',
                'INSERIR_TAREFA',
                'ALTERAR_TAREFA',
                'ARQUIVAR_TAREFA',
                'VER_KANBAN',
                'VER_GANTT',
                'INSERIR_OBSERVACAO_TAREFA',
                'EXPORTAR_PROJETO_TRELLO'
            ]);
        $roleDesenvolvedor = Role::findByName('DESENVOLVEDOR');
        $roleDesenvolvedor->givePermissionTo([
            'LISTAR_TAREFA',
            'ALTERAR_TAREFA',
            'VER_KANBAN',
            'INSERIR_OBSERVACAO_TAREFA'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
