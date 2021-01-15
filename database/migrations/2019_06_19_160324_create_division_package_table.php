<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDivisionPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('division_package', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('division_id');
            $table->unsignedInteger('package_id');
            $table->foreign('division_id')->references('id')->on('divisions');
            $table->foreign('package_id')->references('id')->on('packages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('division_package');
    }
}
