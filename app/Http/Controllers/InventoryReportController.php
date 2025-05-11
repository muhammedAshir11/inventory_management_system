<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\StockMovement;
use DB;

class InventoryReportController extends Controller
{
    public function index(Request $request)
    {
        try {
            
            $productId = $request->product_id ?? null;
            $warehouseId = $request->warehouse_id ?? null;

            $cacheKey = 'inventory_report_' . md5("p:$productId-w:$warehouseId");

            $response = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($productId, $warehouseId) {
                return StockMovement::query()
                    ->select('product_id', 'warehouse_id', DB::raw('GREATEST(SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END), 0) as total_stock'))
                    ->with(['product:id,name', 'warehouse:id,name'])
                    ->when($productId, fn($q) => $q->where('product_id', $productId))
                    ->when($warehouseId, fn($q) => $q->where('warehouse_id', $warehouseId))
                    ->groupBy('product_id', 'warehouse_id')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'product_id' => $item->product_id,
                            'product_name' => $item->product->name ?? null,
                            'warehouse_id' => $item->warehouse_id,
                            'warehouse_name' => $item->warehouse->name ?? null,
                            'total_stock' => (int) $item->total_stock,
                        ];
                    })
                    ->toArray(); // <== convert to array before caching
            });
            return response()->json($response,200);

        } catch (\Throwable $th) {
            return response()->json(['message' => 'Somthing went wrong.'],500);
        }
    }
}
