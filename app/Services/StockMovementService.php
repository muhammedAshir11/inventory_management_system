<?php

namespace App\Services;

use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use App\Events\StockMovementEvent;

class StockMovementService
{
    public function recordMovement(array $data): StockMovement
    {
        return DB::transaction(function () use ($data) {
            $movement = StockMovement::create($data);
            event(new StockMovementEvent($movement));

            return $movement;
        });
    }
}
