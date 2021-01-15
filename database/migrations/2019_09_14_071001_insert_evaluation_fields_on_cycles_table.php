<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertEvaluationFieldsOnCyclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cycles', function (Blueprint $table) {
            $table->string('evaluation_signed_on_place')->nullable();
            $table->string('evaluation_signed_on_date')->nullable();
            $table->string('evaluation_signed_by_position')->nullable();
            $table->string('evaluation_signed_by_name')->nullable();
            $table->string('evaluation_signed_by_identifier')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cycles', function (Blueprint $table) {
            $table->dropColumn('evaluation_signed_on_place');
            $table->dropColumn('evaluation_signed_on_date');
            $table->dropColumn('evaluation_signed_by_position');
            $table->dropColumn('evaluation_signed_by_name');
            $table->dropColumn('evaluation_signed_by_identifier');
        });
    }
}
