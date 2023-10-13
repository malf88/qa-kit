<?php

namespace App\Modules\GestaoProjetos\Jobs;

use App\Modules\GestaoProjetos\Business\ExportCardTrelloBusiness;
use App\Modules\GestaoProjetos\Contracts\Business\ExportBoardTrelloBusinessContract;
use App\Modules\GestaoProjetos\Contracts\Business\ExportCardTrelloBusinessContract;
use App\Modules\GestaoProjetos\DTOs\ProjetoDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;

class TrelloExportCardJobs implements ShouldQueue
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
        public int $idCard,
        public int $idEquipe
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(ExportCardTrelloBusinessContract $exportCardTrelloBusiness): void
    {
        $exportCardTrelloBusiness->exportar( $this->idCard,  $this->idEquipe);
    }
}
