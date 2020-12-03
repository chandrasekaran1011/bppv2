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
        Permission::create(['name' => 'Blacklist Partner','perm_group'=>'Functions']);
        Permission::create(['name' => 'Whitelist Partner','perm_group'=>'Functions']);
        Permission::create(['name' => 'Renew Partner','perm_group'=>'Functions']);
        Permission::create(['name' => 'Delete Partner','perm_group'=>'Functions']);
        Permission::create(['name' => 'Upload Files','perm_group'=>'Functions']);
        Permission::create(['name' => 'Edit Data','perm_group'=>'Functions']);
        Permission::create(['name' => 'View Dashboard','perm_group'=>'Functions']);

        Permission::create(['name' => 'Create Arrangements','perm_group'=>'Functions']);
        Permission::create(['name' => 'Delete Arrangements','perm_group'=>'Functions']);
        Permission::create(['name' => 'Generate Reports','perm_group'=>'Functions']);
        Permission::create(['name' => 'Search Partner','perm_group'=>'Functions']);


        Permission::create(['name' => 'Compliance Approver','perm_group'=>'Compliance']);
        Permission::create(['name' => 'Group Compliance Approver','perm_group'=>'Compliance']);
        Permission::create(['name' => 'Entity Head','perm_group'=>'Compliance']);
        Permission::create(['name' => 'Committee Compliance Approver','perm_group'=>'Compliance']);
        Permission::create(['name' => 'Finance Approver','perm_group'=>'Compliance']);
    }
}
