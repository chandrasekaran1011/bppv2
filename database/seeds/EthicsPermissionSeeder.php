<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class EthicsPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'Create Partner','perm_group'=>'Functions']);
        Permission::create(['name' => 'View Partner','perm_group'=>'Functions']);
        Permission::create(['name' => 'View Search Results','perm_group'=>'Functions']);
        Permission::create(['name' => 'View Audit','perm_group'=>'Functions']);


        Permission::create(['name' => 'Compliance Approver','perm_group'=>'Compliance']);
        Permission::create(['name' => 'Group Compliance Approver','perm_group'=>'Compliance']);
        Permission::create(['name' => 'Committee Compliance Approver','perm_group'=>'Compliance']);
    }
}
