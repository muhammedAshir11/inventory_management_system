<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\StockMovementLog;
use App\Models\StockMovement;

class LogStockMovementJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public StockMovement $movement)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        StockMovementLog::insert([
            'stock_movement_id' => $this->movement->id,
            'data' => json_encode($this->movement->toArray()),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
