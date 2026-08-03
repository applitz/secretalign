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
            $table->boolean('primary_case_movix_status') ->default(0) ->comment('0 = Success, 1 = faild')
                    ->after('primary_case_id');
            $table->boolean('optional_scan_case_movix_status')
                    ->default(0)
                    ->comment('0 = Success, 1 = faild')
                    ->after('optional_scan_case_id');
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
             $table->dropColumn([
                'primary_case_movix_status',
                'optional_scan_case_movix_status',
            ]);
        });
    }
};
