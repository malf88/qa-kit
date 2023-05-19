<?php

namespace App\System;

enum PermisissionEnum:string
{
    case ACESSAR_SISTEMA = 'ACESSAR_SISTEMA';
        case LISTAR_APLICACAO = 'LISTAR_APLICACAO';
        case REMOVER_APLICACAO = 'REMOVER_APLICACAO';
        case INSERIR_APLICACAO = 'INSERIR_APLICACAO';
        case ALTERAR_APLICACAO = 'ALTERAR_APLICACAO';

        case LISTAR_PROJETO = 'LISTAR_PROJETO';
        case REMOVER_PROJETO = 'REMOVER_PROJETO';
        case INSERIR_PROJETO = 'INSERIR_PROJETO';
        case ALTERAR_PROJETO = 'ALTERAR_PROJETO';
        case ADICIONAR_COMENTARIO_PROJETO = 'ADICIONAR_COMENTARIO_PROJETO';
        case ADICIONAR_DOCUMENTO_PROJETO = 'ADICIONAR_DOCUMENTO_PROJETO';

        case LISTAR_PLANO_TESTE = 'LISTAR_PLANO_TESTE';
        case REMOVER_PLANO_TESTE = 'REMOVER_PLANO_TESTE';
        case INSERIR_PLANO_TESTE = 'INSERIR_PLANO_TESTE';
        case ALTERAR_PLANO_TESTE = 'ALTERAR_PLANO_TESTE';

        case LISTAR_CASO_TESTE = 'LISTAR_CASO_TESTE';
        case REMOVER_CASO_TESTE = 'REMOVER_CASO_TESTE';
        case INSERIR_CASO_TESTE = 'INSERIR_CASO_TESTE';
        case ALTERAR_CASO_TESTE = 'ALTERAR_CASO_TESTE';

        case LISTAR_EXECUCAO_PLANO_TESTE = 'LISTAR_EXECUCAO_PLANO_TESTE';
        case REMOVER_EXECUCAO_PLANO_TESTE = 'REMOVER_EXECUCAO_PLANO_TESTE';
        case INSERIR_EXECUCAO_PLANO_TESTE = 'INSERIR_EXECUCAO_PLANO_TESTE';
        case ALTERAR_EXECUCAO_PLANO_TESTE = 'ALTERAR_EXECUCAO_PLANO_TESTE';
        case EXECUTAR_CASO_TESTE = 'EXECUTAR_CASO_TESTE';
        case FINALIZAR_PLANO_TESTE = 'FINALIZAR_PLANO_TESTE';
        case VINCULAR_CASO_TESTE = 'VINCULAR_CASO_TESTE';
        case DESVINCULAR_CASO_TESTE = 'DESVINCULAR_CASO_TESTE';

        case REMOVER_DOCUMENTO_PROJETO = 'REMOVER_DOCUMENTO_PROJETO';
        case REMOVER_COMENTARIO_PROJETO = 'REMOVER_COMENTARIO_PROJETO';
}
