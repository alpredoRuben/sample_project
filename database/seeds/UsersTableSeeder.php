<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    private function findRole($roleName)
    {
        return Role::where('name', $roleName)->first();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $general = User::create([
            'name' => 'Dummy User',
            'email' => 'dummy@localhost.com',
            'password' => bcrypt('12345678')
        ]);

        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@localhost.com',
            'password' => bcrypt('12345678'),
        ]);


        /** Set Admin */
        $roleAdmin = $this->findRole('admin');
        $permissions = Permission::pluck('id', 'id')->all();
        $roleAdmin->syncPermissions($permissions);
        $admin->assignRole([$roleAdmin->id]);

        /** Set Admin */
        $roleGeneral = $this->findRole('general');
        $permissions = Permission::whereIn('name', ['find-category', 'show-categories', 'find-product', 'show-products'])->get();
        $roleGeneral->syncPermissions($permissions);
        $general->assignRole([$roleGeneral->id]);
    }
}
