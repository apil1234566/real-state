<?php

use App\SystemCharge;
use Illuminate\Database\Seeder;

class SystemChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemCharge::create([
            'system_charge' => 10,    
        ]);
    }
}
