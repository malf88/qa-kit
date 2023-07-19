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
        Permission::create(['name' => 'ACESSAR_SISTEMA']);

        Permission::create(['name' => 'LISTAR_APLICACAO']);
        Permission::create(['name' => 'REMOVER_APLICACAO']);
        Permission::create(['name' => 'INSERIR_APLICACAO']);
        Permission::create(['name' => 'ALTERAR_APLICACAO']);

        Permission::create(['name' => 'LISTAR_PROJETO']);
        Permission::create(['name' => 'REMOVER_PROJETO']);
        Permission::create(['name' => 'INSERIR_PROJETO']);
        Permission::create(['name' => 'ALTERAR_PROJETO']);
        Permission::create(['name' => 'ADICIONAR_COMENTARIO_PROJETO']);
        Permission::create(['name' => 'ADICIONAR_DOCUMENTO_PROJETO']);
        Permission::create(['name' => 'REMOVER_COMENTARIO_PROJETO']);
        Permission::create(['name' => 'REMOVER_DOCUMENTO_PROJETO']);

        Permission::create(['name' => 'LISTAR_PLANO_TESTE']);
        Permission::create(['name' => 'REMOVER_PLANO_TESTE']);
        Permission::create(['name' => 'INSERIR_PLANO_TESTE']);
        Permission::create(['name' => 'ALTERAR_PLANO_TESTE']);

        Permission::create(['name' => 'LISTAR_CASO_TESTE']);
        Permission::create(['name' => 'VINCULAR_CASO_TESTE']);
        Permission::create(['name' => 'DESVINCULAR_CASO_TESTE']);
        Permission::create(['name' => 'REMOVER_CASO_TESTE']);
        Permission::create(['name' => 'INSERIR_CASO_TESTE']);
        Permission::create(['name' => 'ALTERAR_CASO_TESTE']);
        Permission::create(['name' => 'IMPORTAR_PLANILHA_CASO_TESTE']);

        Permission::create(['name' => 'LISTAR_EXECUCAO_PLANO_TESTE']);
        Permission::create(['name' => 'REMOVER_EXECUCAO_PLANO_TESTE']);
        Permission::create(['name' => 'INSERIR_EXECUCAO_PLANO_TESTE']);
        Permission::create(['name' => 'ALTERAR_EXECUCAO_PLANO_TESTE']);
        Permission::create(['name' => 'EXECUTAR_CASO_TESTE']);
        Permission::create(['name' => 'FINALIZAR_PLANO_TESTE']);

        $roleAdministrador = Role::findByName('ADMINISTRADOR');
        $roleAdministrador->syncPermissions(Permission::all());

        $roleAuditor = Role::findByName('AUDITOR');
        $roleAuditor->givePermissionTo([
            'LISTAR_EXECUCAO_PLANO_TESTE',
            'REMOVER_EXECUCAO_PLANO_TESTE',
            'INSERIR_EXECUCAO_PLANO_TESTE',
            'ALTERAR_EXECUCAO_PLANO_TESTE',
            'LISTAR_CASO_TESTE',
            'REMOVER_CASO_TESTE',
            'INSERIR_CASO_TESTE',
            'ALTERAR_CASO_TESTE',
            'LISTAR_APLICACAO',
            'LISTAR_PROJETO',
            'LISTAR_PLANO_TESTE',
            'EXECUTAR_CASO_TESTE',
            'FINALIZAR_PLANO_TESTE',
            'ALTERAR_PROJETO',
            'ACESSAR_SISTEMA',
            'VINCULAR_CASO_TESTE',
            'DESVINCULAR_CASO_TESTE',
            'IMPORTAR_PLANILHA_CASO_TESTE'

        ]);

        $roleGestor = Role::findByName('GESTOR');
        $roleGestor->givePermissionTo([
            'LISTAR_EXECUCAO_PLANO_TESTE',
            'REMOVER_EXECUCAO_PLANO_TESTE',
            'INSERIR_EXECUCAO_PLANO_TESTE',
            'ALTERAR_EXECUCAO_PLANO_TESTE',
            'LISTAR_CASO_TESTE',
            'REMOVER_CASO_TESTE',
            'INSERIR_CASO_TESTE',
            'ALTERAR_CASO_TESTE',
            'LISTAR_APLICACAO',
            'LISTAR_PROJETO',
            'LISTAR_PLANO_TESTE',
            'ALTERAR_APLICACAO',
            'ADICIONAR_COMENTARIO_PROJETO',
            'ADICIONAR_DOCUMENTO_PROJETO',
            'ACESSAR_SISTEMA',
            'REMOVER_COMENTARIO_PROJETO',
            'REMOVER_DOCUMENTO_PROJETO'
        ]);

        $roleDesenvolvedor = Role::findByName('DESENVOLVEDOR');
        $roleDesenvolvedor->givePermissionTo([
            'LISTAR_EXECUCAO_PLANO_TESTE',
            'INSERIR_EXECUCAO_PLANO_TESTE',
            'LISTAR_CASO_TESTE',
            'LISTAR_APLICACAO',
            'LISTAR_PROJETO',
            'LISTAR_PLANO_TESTE',
            'EXECUTAR_CASO_TESTE',
            'FINALIZAR_PLANO_TESTE',
            'ACESSAR_SISTEMA'
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
