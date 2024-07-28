<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = [
            [
                'name' => 'Basic',
                'description' => 'Basic package with limited features, valid for 1 month',
                'price' => 1000,
                'duration' => 'monthly',
                'billing_interval' => 'month',
                'active' => true,
                'type'=>1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
           [
                'name' => 'Basic Plus',
                'description' =>'Basic Plus package with extended features, valid for 3 months',
                'price' => 2500,
                'duration' => '3 months',
                'billing_interval' => 'month',
                'active' => true,
                'type' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pro',
                'description' => 'Pro package with advanced features, valid for 6 months',
                'price' => 5000,
                'duration' => '6 months',
                'billing_interval' => 'month',
                'active' => true,
                'type' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pro Plus',
                'description' => 'Pro Plus package with premium features, valid for 1 year',
                'price' => 12000,
                'duration' => '1 year',
                'billing_interval' => 'year',
                'active' => true,
                'type' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];
        DB::table('packages')->insert($packages);
    }
}
