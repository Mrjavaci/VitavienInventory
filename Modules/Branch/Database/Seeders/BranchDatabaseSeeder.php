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
            'name'    => 'Kumburgaz Şube',
            'address' => 'Main Branch Address',
            'phone'   => '+90214124124124',
            'email'   => 'kumburgaz@kumburgaz.com',
        ]);
        Branch::query()->create([
            'name'    => 'Silivri Şube',
            'address' => 'Silivri Şube Address',
            'phone'   => '+90214124124124',
            'email'   => 'silivri@silivri.com',
        ]);
    }
}
