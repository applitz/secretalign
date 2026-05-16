<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctor_clinical_preferences', function (Blueprint $table) {
            $table->string('ipr_location_upper')->nullable()->after('ipr_max_limit');
            $table->string('ipr_location_lower')->nullable()->after('ipr_location_upper');
            $table->text('resolutions_notes')->nullable()->after('ipr_location_lower');
        });
    }

    public function down(): void
    {
        Schema::table('doctor_clinical_preferences', function (Blueprint $table) {
            $table->dropColumn(['ipr_location_upper', 'ipr_location_lower', 'resolutions_notes']);
        });
    }
};
