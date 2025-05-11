<?php

namespace App\Services;

use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use App\Events\StockMovementEvent;
use App\jobs\LogStockMovementJob;

class StockMovementService
{
    public function recordMovement(array $data): StockMovement
    {
        return DB::transaction(function () use ($data) {
            $movement = StockMovement::create($data);

            // Dispatch event (cache invalidation)
            event(new StockMovementEvent($movement));

            // Dispatch job to log
            LogStockMovementJob::dispatch($movement);

            return $movement;
        });
    }
}
