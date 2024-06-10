<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesAndPermissions = [
            'Admin' => [
                'view bank_lagu',
                'view kasir',
                'view pembayaran',
            ],
            'SUPER ADMIN' => [],
        ];
        foreach ($rolesAndPermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            foreach ($permissions as $permission) {
                if ($role->name !== 'SUPER ADMIN') {
                    $permission =  Permission::firstOrCreate(['name' => $permission]);
                    $role->givePermissionTo($permission);
                }
            }
        }
        // Role::where('name', 'SUPER ADMIN')->first()->givePermissionTo(Permission::all());

        // sintak memperbaharui
        // php artisan db:seed --class=RolesAndPermissionsSeeder
        // Role::where('name', 'ADMIN FAKULTAS/UNIT')->first()->givePermissionTo('view SBM&SBI');
    }
}
