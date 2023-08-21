<?php

namespace App\System\Traits;

use Illuminate\Support\Facades\DB;

trait TransactionDatabase
{
    public function startTransaction():void
    {
        DB::beginTransaction();
    }
    public function commit(): void
    {
        DB::commit();
    }

    public function rollback(): void
    {
        DB::rollBack();
    }
}
