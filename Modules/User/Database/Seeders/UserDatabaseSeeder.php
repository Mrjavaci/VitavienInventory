<?php

namespace Modules\User\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Modules\User\App\Models\User;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fakerFactory = Factory::create('tr_TR');
        User::query()->create([
            'name'      => $fakerFactory->name,
            'email'     => 'branch@branch.com',
            'password'  => bcrypt('asd'),
            'user_type' => 'Branch',
            'user_type_id' => 1
        ]);

        User::query()->create([
            'name'      => $fakerFactory->name,
            'email'     => 'warehouse@warehouse.com',
            'password'  => bcrypt('asd'),
            'user_type' => 'WareHouse',
            'user_type_id' => 1
        ]);
        User::query()->create([
            'name'      => $fakerFactory->name,
            'email'     => 'system@system.com',
            'password'  => bcrypt('asd'),
            'user_type' => 'System',
            'user_type_id' => 0
        ]);
    }
}
