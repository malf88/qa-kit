<?php

namespace App\Modules\GestaoProjetos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntegracaoProjeto extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'integracoes.integracoes_projetos';
    protected $fillable = [
      'projeto_id',
      'id_externo',
      'retorno'
    ];
}
