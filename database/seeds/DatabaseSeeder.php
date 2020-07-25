<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(ApplicationSeeder::class);
        $this->call(PartnerTypeSeeder::class);
        $this->call(EthicsMasterSeeder::class);
        $this->call(EthicsPermissionSeeder::class);

    }
}
