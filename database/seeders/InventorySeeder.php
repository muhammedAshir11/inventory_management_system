<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\StockMovement;
use DB;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Product::factory(1000)->create();
        Warehouse::factory(10)->create();

        $movements = [];
        for ($i = 0; $i < 10000; $i++) {
            $movements[] = [
                'product_id' => rand(1, 1000),
                'warehouse_id' => rand(1, 10),
                'quantity' => rand(1, 100),
                'type' => rand(0, 1) ? 'in' : 'out',
                'movement_date' => now()->subDays(rand(0, 365)),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($movements) === 500) {
                DB::table('stock_movements')->insert($movements);
                $movements = [];
            }
        }

        // Insert any remaining records
        if (!empty($movements)) {
            DB::table('stock_movements')->insert($movements);
        }
    }
}
