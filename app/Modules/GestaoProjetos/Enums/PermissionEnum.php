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
    case VER_KANBAN = 'VER_KANBAN';
    case VER_GANTT = 'VER_GANTT';


}
