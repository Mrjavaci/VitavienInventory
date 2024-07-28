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
            'email'     => $fakerFactory->email,
            'password'  => $fakerFactory->password,
            'user_type' => 'Branch',
            'user_type_id' => 1
        ]);

        User::query()->create([
            'name'      => $fakerFactory->name,
            'email'     => $fakerFactory->email,
            'password'  => $fakerFactory->password,
            'user_type' => 'WareHouse',
            'user_type_id' => 1
        ]);
        User::query()->create([
            'name'      => $fakerFactory->name,
            'email'     => $fakerFactory->email,
            'password'  => $fakerFactory->password,
            'user_type' => 'System',
            'user_type_id' => 0
        ]);
    }
}
