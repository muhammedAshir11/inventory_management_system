<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\InventoryReportService;


class InventoryReportController extends Controller
{
    protected $reportService;

    public function __construct(InventoryReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index(Request $request)
    {
        try {

            $productId   = $request->product_id ?? null;
            $warehouseId = $request->warehouse_id ?? null;
            $response    = $this->reportService->generate($productId, $warehouseId);

            return response()->json($response,200);

        } catch (\Throwable $th) {
            return response()->json(['message' => 'Somthing went wrong.'],500);
        }
    }
}
