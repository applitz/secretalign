<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_treatment_plans', function (Blueprint $table) {
            $table->enum('send_back_to_doctor_status', ['0', '1'])
                  ->default('0')
                  ->after('is_rejected')
                  ->comment('Status indicating if the treatment plan has been sent back to the doctor for review');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p_treatment_plans', function (Blueprint $table) {
            $table->dropColumn('send_back_to_doctor_status');
        });
    }
};
