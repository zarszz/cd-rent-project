<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPayRentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_pay_rent', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rent_id');
            $table->double('total_payment', 8, 2);
            $table->integer('rental_duration');
            $table->boolean('is_already_do_payment')->default(FALSE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_pay_rent');
    }
}
