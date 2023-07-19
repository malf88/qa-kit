<?php

namespace App\Modules\GestaoProjetos\Enums;

enum TarefaStatusEnum:string
{
    case ABERTA = 'Aberta';
    case EM_DESENVOLVIMENTO = 'Em desenvolvimento';
    case EM_AUDITORIA = 'Em auditoria';
    case EM_PUBLICACAO = 'Em publicação';
    case CANCELADA = 'Cancelada';
    case CONCLUIDA = 'Concluída';
    case ARQUIVADA = 'Arquivada';

}
