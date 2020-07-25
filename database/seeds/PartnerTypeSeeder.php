<?php

use Illuminate\Database\Seeder;
use App\Models\Ethics\PartnerType;


class PartnerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PartnerType::create(['name'=>'Public Client']);
        PartnerType::create(['name'=>'Private Client']);
        PartnerType::create(['name'=>'Consortium member']);
        PartnerType::create(['name'=>'JV partner']);
        PartnerType::create(['name'=>'Sub-contractor']);
        PartnerType::create(['name'=>'Supplier']);
        PartnerType::create(['name'=>'Intermediary']);
        PartnerType::create(['name'=>'Individual']);
    }
}
