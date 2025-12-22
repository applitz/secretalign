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
            $table->date('expiry_date')->after('status')->nullable();
            // ALTER TABLE `p_treatment_plans` ADD `expiry_date` DATE NULL AFTER `status`;
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
            $table->dropColumn('expiry_date');
        });
    }
};
