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
            $table->boolean('is_link_updated')->default(0)->comment('0 For No, 1 for Yes')->after('patient_link');
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
            $table->dropColumn('is_link_updated');
        });
    }
};
