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
           $table->dropColumn([
                'primary_presigned_links_details',
                'optional_presigned_links_details',
             ]);
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
            $table->json('primary_presigned_links_details')->nullable()->after('primary_note');
            $table->json('optional_presigned_links_details')->nullable()->after('optional_scan_note');
        });
    }
};
