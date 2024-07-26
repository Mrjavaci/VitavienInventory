<?php

namespace Modules\Stock\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Stock\App\Models\Stock;
use Modules\Stock\App\Models\StockUnit;

class StockDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kilogram = StockUnit::query()->create([
            'name' => 'Kilogram',
        ]);
        $piece = StockUnit::query()->create([
            'name' => 'Piece',
        ]);
        $liter = StockUnit::query()->create([
            'name' => 'Liter',
        ]);

        Stock::query()->create([
            'name'          => 'Apple',
            'stock_unit_id' => $piece->id,
        ]);
        Stock::query()->create([
            'name'          => 'Milk',
            'stock_unit_id' => $liter->id,
        ]);
        Stock::query()->create([
            'name'          => 'chocolate',
            'stock_unit_id' => $kilogram->id,
        ]);
    }
}
