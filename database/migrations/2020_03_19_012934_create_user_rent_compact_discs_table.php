<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRentCompactDiscsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_rent_compact_discs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('compact_disc_id');
            $table->datetime('rent_date')->useCurrent();
            $table->timestamp('return_date')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('compact_disc_id')->references('id')->on('compact_discs');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_rent_compact_discs');
    }
}
