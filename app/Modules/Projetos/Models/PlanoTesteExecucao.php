<?php

namespace App\Modules\Projetos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanoTesteExecucao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projetos.plano_teste_execucoes';
    protected $fillable = [
        'resultado',
        'user_id',
        'data_execucao',
        'plano_teste_id',
        'caso_teste_id'
    ];
    public function caso_teste_execucao()
    {
        return $this->hasMany(CasoTesteExecucao::class);

    }

    public function plano_teste()
    {
        return $this->belongsTo(PlanoTeste::class);

    }
}
