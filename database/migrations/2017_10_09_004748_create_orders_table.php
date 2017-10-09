<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('user_delivery_man_id')->unsigned()->nullable();
            $table->decimal('total');
            $table->smallInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('client_id')
                ->references('id')
                ->on('users');

            $table->foreign('user_delivery_man_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
