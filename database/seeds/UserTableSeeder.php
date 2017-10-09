<?php

use CodeDelivery\Models\Client;
use CodeDelivery\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Clientes
        factory(User::class, 10)->create()->each(function($user){
            $user->client()->save(factory(Client::class)->make());
        });
    }
}
