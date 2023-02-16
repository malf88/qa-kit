<?php

namespace App\Domain\Projects\Models;

use App\Application\Abstracts\ModelAbstract;
use App\Application\Traits\MigrationTrait;
use App\Domain\Auth\Models\User;
use App\Domain\Projects\Configuration\DomainConfigurationProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Project extends ModelAbstract
{
    use HasFactory,MigrationTrait, SoftDeletes;
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    protected $visible = [
        'name',
        'branchs',
        'strategy',
        'url_repository',
        'url_git_clone',
        'clone_type',
        'custom_script',
        'uuid'
    ];
    protected $fillable = [
        'name',
        'branchs',
        'strategy',
        'url_repository',
        'url_git_clone',
        'clone_type',
        'custom_script'
    ];
    protected $casts = [
        'branchs' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getTable()
    {
        return $this->getTableName('projects',DomainConfigurationProject::getDatabaseSchema());
    }
}
