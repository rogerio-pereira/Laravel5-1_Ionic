<?php

use CodeDelivery\Models\API\OAuthClients;
use Illuminate\Database\Seeder;

class ApiOAuthClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OAuthClients::class)->create([
            'id' => 'appid01',
            'secret' => 'secret', //DEVE SER UM HASH, USADO STRING NORMAL PARA FACILITAR OS TESTES
            'name' => 'Minha App Mobile',
        ]);
    }
}
