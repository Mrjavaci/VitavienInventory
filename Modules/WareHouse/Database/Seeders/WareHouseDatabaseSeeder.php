<?php

namespace Modules\WareHouse\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\WareHouse\App\Models\WareHouse;

class WareHouseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WareHouse::query()->create([
            'name'     => 'Warehouse 1',
            'location' => 'Location 1',
        ]);

        WareHouse::query()->create([
            'name'     => 'Warehouse 2',
            'location' => 'Location 2',
        ]);
    }
}
