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
            $table->text('primary_case_id')->nullable()->after('fl_lower_arch');
            $table->text('primary_client')->nullable()->after('primary_case_id');
            $table->text('primary_note')->nullable()->after('primary_client');
            $table->longText('primary_movix_note')->nullable()->after('primary_note');
            $table->text('primary_movix_link')->nullable()->after('primary_movix_note');
            $table->timestamp('primary_movix_link_expires_at')->after('primary_movix_link')->nullable();
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
                'primary_case_id',
                'primary_client',
                'primary_note',
                'primary_movix_note',
                'primary_movix_link',
                'primary_movix_link_expires_at',
            ]);
        });
    }
};
