<?php

namespace Modules\Branch\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Branch\App\Models\Branch;

class BranchDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::query()->create([
            'name'    => 'Main Branch',
            'address' => 'Main Branch Address',
            'phone'   => 'Main Branch Phone',
            'email'   => 'Main Branch Email',
        ]);
        Branch::query()->create([
            'name'    => 'Another Branch',
            'address' => 'Another Branch Address',
            'phone'   => 'Another Branch Phone',
            'email'   => 'Another Branch Email',
        ]);
    }
}
