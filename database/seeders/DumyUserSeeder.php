<?php

namespace Database\Seeders;

use App\Models\RenstraIndicator;
use App\Models\RenstraMission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DumyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $u = User::firstOrCreate([
            'name' => 'Super Adm',
            'email' => 'admin2@mail.com',

        ], ['password' => Hash::make('123'),]);
        $u->assignRole('SUPER ADMIN');
    }
}
