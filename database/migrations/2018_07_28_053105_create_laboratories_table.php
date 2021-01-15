<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaboratoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('ownership_id');
            $table->string('address')->nullable();
            $table->string('village')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->unsignedInteger('province_id');
            $table->string('postal_code', 6)->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number', 36)->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('user_position')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('type_id')->references('id')->on('laboratory_types');
            $table->foreign('ownership_id')->references('id')->on('laboratory_ownerships');
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laboratories');
    }
}
