<?php

namespace App\Modules\GestaoProjetos\Enums;

enum PermissionEnum:string
{
    case LISTAR_TAREFA = 'LISTAR_TAREFA';
    case REMOVER_TAREFA = 'REMOVER_TAREFA';
    case INSERIR_TAREFA = 'INSERIR_TAREFA';
    case ALTERAR_TAREFA = 'ALTERAR_TAREFA';
    case ARQUIVAR_TAREFA = 'ARQUIVAR_TAREFA';
    case INSERIR_OBSERVACAO_TAREFA = 'INSERIR_OBSERVACAO_TAREFA';
    case PODE_ALTERAR_TAREFA_CONCLUIDA = 'PODE_ALTERAR_TAREFA_CONCLUIDA';
    case VER_GANTT = 'VER_GANTT';
    case EXPORTAR_PROJETO_TRELLO = 'EXPORTAR_PROJETO_TRELLO';
    case IMPORTAR_PROJETO_TRELLO = 'IMPORTAR_PROJETO_TRELLO';

}
