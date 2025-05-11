<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StockMovementRequest;
use App\Services\StockMovementService;

class StockMovementController extends Controller
{
    public function store(StockMovementRequest $request)
    {
        try{
            $movement = (new StockMovementService())->recordMovement($request->validated());
            return response()->json(['message' => 'Stock movement recorded', 'data' => $movement], 201);

        }catch(\Exception $exception){
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }
}
