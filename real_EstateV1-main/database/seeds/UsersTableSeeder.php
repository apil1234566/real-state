<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123'),
            'admin' => 1,
            'email_verified_at' => \Carbon\Carbon::now()
        ]);

        //owner 1 

        $agent = User::create([
            'name' => 'Agent 1',
            'email' => 'agent1@mail.com',
            'password' => bcrypt('password'),
            'role' => 1,
            'email_verified_at' => \Carbon\Carbon::now()
        ]);

        $agent->owner()->create([
            'phone' => '123456789',
            'city_id' => 3,
            'place_id' => 11,
            'link' => 'www.google.com',
            'description' => 'I am owner number one',
            'created_at' => \Carbon\Carbon::now()
        ]);

        //agent2
        $agent2 = User::create([
            'name' => 'Agent 2',
            'email' => 'agent2@mail.com',
            'password' => bcrypt('password'),
            'role' => 1,
            'email_verified_at' => \Carbon\Carbon::now()
        ]);

        $agent2->owner()->create([
            'phone' => '123456789',
            'city_id' => 3,
            'place_id' => 11,
            'link' => 'www.google.com',
            'description' => 'I am owner number one',
            'created_at' => \Carbon\Carbon::now()
        ]);

        //seeker one
        $cleint1 = User::create([
            'name' => 'Client 1',
            'email' => 'cleint1@mail.com',
            'password' => bcrypt('password'),
            'role' => 2,
            'email_verified_at' => Carbon\Carbon::now()
        ]);

        $cleint1->seeker()->create([
            'phone' => '123456789',
            'link' => 'www.google.com',
            'alternate_phone' => '1234567',
            'place_id' => 1,
            'city_id' => 1,
            'description' => 'I am owner number one',
            'created_at' => \Carbon\Carbon::now()
        ]);

        //seeker 2
        $client2 = User::create([
            'name' => 'Client 2',
            'email' => 'client2@mail.com',
            'password' => bcrypt('password'),
            'role' => 2,
            'email_verified_at' => Carbon\Carbon::now()
        ]);
        
        $client2->seeker()->create([
            'phone' => '123456789',
            'link' => 'www.google.com',
            'alternate_phone' => '1234567',
            'place_id' => 5,
            'city_id' => 2,
            'description' => 'I am owner number one',
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
