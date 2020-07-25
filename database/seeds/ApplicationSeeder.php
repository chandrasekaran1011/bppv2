<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Application;
use App\Models\Admin\BusinessUnit;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Permission::create(['name' => 'View All Records','perm_group'=>'Access']);
        Permission::create(['name' => 'View BU Records','perm_group'=>'Access']);
        Permission::create(['name' => 'View Project Records','perm_group'=>'Access']);
        Permission::create(['name' => 'View His Records','perm_group'=>'Access']);
    }
}
