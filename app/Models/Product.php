<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\StockMovement;


class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'sku', 'description'];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

}
