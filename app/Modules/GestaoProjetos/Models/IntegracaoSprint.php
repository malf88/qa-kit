<?php

namespace App\Modules\GestaoProjetos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntegracaoSprint extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'integracoes.integracoes_sprint';
}
