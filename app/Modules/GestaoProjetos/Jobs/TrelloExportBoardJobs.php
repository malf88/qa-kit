<?php

namespace App\Modules\GestaoProjetos\Jobs;

use App\Modules\GestaoProjetos\Contracts\Business\ExportBoardTrelloBusinessContract;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;

class TrelloExportBoardJobs implements ShouldQueue
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
    public function handle(ExportBoardTrelloBusinessContract $exportProjectTrelloBusiness): void
    {
        $exportProjectTrelloBusiness->exportar( $this->idProjeto,  $this->idEquipe);
    }
}
