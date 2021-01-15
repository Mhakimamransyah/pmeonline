<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCertificateSignerOnCycleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cycles', function (Blueprint $table) {
            $table->string('certificate_signed_on_place')->nullable();
            $table->string('certificate_signed_on_date')->nullable();
            $table->string('certificate_signed_by_position')->nullable();
            $table->string('certificate_signed_by_name')->nullable();
            $table->string('certificate_signed_by_identifier')->nullable();
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
            $table->dropColumn('certificate_signed_on_place');
            $table->dropColumn('certificate_signed_on_date');
            $table->dropColumn('certificate_signed_by_position');
            $table->dropColumn('certificate_signed_by_name');
            $table->dropColumn('certificate_signed_by_identifier');
        });
    }
}
