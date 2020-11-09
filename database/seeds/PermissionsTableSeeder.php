<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function getPermissions()
    {
        return [
            'create-user',
            'update-user',
            'delete-user',
            'find-user',
            'show-users',

            'create-category',
            'update-category',
            'delete-category',
            'find-category',
            'show-categories',


            'create-product',
            'update-product',
            'delete-product',
            'find-product',
            'show-products',

        ];
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = $this->getPermissions();

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
