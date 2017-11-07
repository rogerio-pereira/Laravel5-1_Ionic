<?php

use CodeDelivery\Models\Cupom;
use Illuminate\Database\Seeder;

class CupomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Cupom::class, 10)->create();
        factory(Cupom::class, 10)->create(['code' => '885']);
        factory(Cupom::class, 10)->create(['code' => '886', 'used' => 1]);
    }
}
