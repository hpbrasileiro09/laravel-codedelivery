<?php

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
        factory(\CodeDelivery\Models\User::class)->create([
            'name' => 'Hernando Brasileiro', 
            'email' => 'hpbrasileiro@hotmail.com', 
            'password' => bcrypt('123456'),
        ])->client()->save(factory(\CodeDelivery\Models\Client::class)->make());

        factory(\CodeDelivery\Models\User::class)->create([
            'name' => 'Michel Temer', 
            'email' => 'hpbrasileiro@gmail.com', 
            'password' => bcrypt('123456'),
            'role' => 'admin',
        ])->client()->save(factory(\CodeDelivery\Models\Client::class)->make());

        factory(\CodeDelivery\Models\User::class, 10)->create()->each(function($u) {
       		$u->client()->save(factory(\CodeDelivery\Models\Client::class)->make());
        });

        factory(\CodeDelivery\Models\User::class, 3)->create([
            'role' => 'deliveryman', 
        ]);
    }
}
