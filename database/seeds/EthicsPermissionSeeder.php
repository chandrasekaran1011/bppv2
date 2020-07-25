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
        Permission::create(['name' => 'Compliance Approver','perm_group'=>'Compliance']);
    }
}
