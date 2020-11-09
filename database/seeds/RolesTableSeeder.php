<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function getRoles()
    {
        return [
            'admin',
            'supervisor',
            'cashier',
            'customer',
            'general',
        ];
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = $this->getRoles();

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
