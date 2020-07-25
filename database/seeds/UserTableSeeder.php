<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role=Role::create(['name'=>'Super Admin']);
        Permission::create(['name'=>'view Backend','perm_group'=>'Administration']);
        $role->syncPermissions(['view Backend']);

        $user=User::create([
            'name'=>'Chandrasekaran',
            'email'=>'cs@devchandru.com',
            'password'=>bcrypt('password@1011')
        ]);

        

        $user->syncRoles(['Super Admin']);

        

    }
}
