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
            'name' => 'Adet',
        ]);
        $liter = StockUnit::query()->create([
            'name' => 'Litre',
        ]);

        Stock::query()->create([
            'name'          => 'Elma',
            'stock_unit_id' => $piece->id,
        ]);
        Stock::query()->create([
            'name'          => 'Süt',
            'stock_unit_id' => $liter->id,
        ]);
        Stock::query()->create([
            'name'          => 'Kahve',
            'stock_unit_id' => $kilogram->id,
        ]);
        Stock::query()->create([
            'name'          => '50 Ml Su',
            'stock_unit_id' => $piece->id,
        ]);
    }
}
