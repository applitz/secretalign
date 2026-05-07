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
            $table->text('optional_scan_case_id')->nullable()->after('optional_fl_lower_arch');
            $table->text('optional_scan_client')->nullable()->after('optional_scan_case_id');
            $table->text('optional_scan_note')->nullable()->after('optional_scan_client');
            $table->longText('optional_scan_movix_note')->nullable()->after('optional_scan_note');
            $table->text('optional_scan_movix_link')->nullable()->after('optional_scan_movix_note');
            $table->timestamp('optional_scan_movix_link_expires_at')->after('optional_scan_movix_link')->nullable();
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
                'optional_scan_case_id',
                'optional_scan_client',
                'optional_scan_note',
                'optional_scan_movix_note',
                'optional_scan_movix_link',
                'optional_scan_movix_link_expires_at'
            ]);
        });
    }
};
