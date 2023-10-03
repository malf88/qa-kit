<?php

namespace App\Modules\GestaoProjetos\Jobs;

use App\Modules\GestaoProjetos\Contracts\Business\ExportProjectTrelloBusinessContract;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;

class TrelloBoardJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;
    public function middleware(): array
    {
        return [new RateLimited('trello')];
    }
    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $idProjeto,
        public int $idEquipe
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(ExportProjectTrelloBusinessContract $exportProjectTrelloBusiness): void
    {
        $exportProjectTrelloBusiness->exportar( $this->idProjeto,  $this->idEquipe);
    }
}
