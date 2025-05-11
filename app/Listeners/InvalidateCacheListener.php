<?php

namespace App\Listeners;

use App\Events\StockMovementEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class InvalidateCacheListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StockMovementEvent $event): void
    {
        // Invalidate cache using a specific key pattern
        $movement    = $event->movement;
        $productId   = $movement->product_id;
        $warehouseId = $movement->warehouse_id;
        $cacheKey    = 'inventory_report_' . md5("p:$productId-w:$warehouseId");

        // Remove only the specific cache for the inventory report
        Cache::forget($cacheKey);
    }
}
