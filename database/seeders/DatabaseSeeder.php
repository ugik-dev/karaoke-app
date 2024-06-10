<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Employee;
use App\Models\PPK;
use App\Models\User;
use App\Models\Verificator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([RolesAndPermissionsSeeder::class]);
        $this->call([DumyUserSeeder::class]);
        // if (config('app.env') == 'local') {
        //     $sqlFilePath = database_path('seeders/eplanning.sql');

        //     if (File::exists($sqlFilePath)) {
        //         $sql = File::get($sqlFilePath);
        //         DB::unprepared($sql);
        //         $this->command->info('SQL file seeded successfully.');
        //     } else {
        //         $this->command->error('SQL file not found.');
        //     }
        // }
        // Check if the user with email 'admin@mail.com' already exists
        // $adminUser = User::where('email', 'admin@mail.com')->first();
        // If the user doesn't exist, create it
        // if (!$adminUser) {
        //     User::create([
        //         'name' => 'Admin',
        //         'email' => 'admin@mail.com',
        //         'password' => Hash::make(env('ADMIN_PASS')),
        //     ]);
        // }



        // if (env('APP_ENV') === 'local') {
        //     // for testing
        //     // PPK::factory(123)->create();
        //     // Verificator::factory(456)->create();
        //     User::factory(10)->create();
        //     $fakultas1User = User::factory()->create([
        //         'id' => 999,
        //         'name' => 'fakultas 1',
        //         'email' => 'fakultas1@mail.com',
        //         'password' => Hash::make('password')
        //     ]);
        //     $fakultas1User->assignRole('ADMIN FAKULTAS/UNIT');
        // }
        // User::where('name', 'Admin')->first()->assignRole('SUPER ADMIN PERENCANAAN');
    }
}
