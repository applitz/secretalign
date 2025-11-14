<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE p_treatment_plans MODIFY case_holder VARCHAR(255) DEFAULT 'doctor'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE p_treatment_plans MODIFY case_holder VARCHAR(255) DEFAULT 'staff'");
    }
};
