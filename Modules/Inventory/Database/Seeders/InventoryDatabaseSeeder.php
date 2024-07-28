<?php

namespace Modules\Inventory\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Branch\App\Models\Branch;
use Modules\Inventory\App\Models\Inventory;
use Modules\WareHouse\App\Models\WareHouse;

class InventoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Inventory::query()->create([
            'InventoryType' => class_basename(WareHouse::class),
            'inventory_id'  => 2,
            'stock_id'      => 1,
            'amount'        => 10,
        ]);

        Inventory::query()->create([
            'InventoryType' => class_basename(Branch::class),
            'inventory_id'  => 1,
            'stock_id'      => 2,
            'amount'        => 20,
        ]);
    }
}
