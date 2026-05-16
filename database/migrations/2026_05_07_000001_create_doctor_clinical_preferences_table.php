<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_clinical_preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->string('anterior_teeth_leveling')->nullable();
            $table->string('pontics_selection')->nullable();
            $table->string('arch_expansion')->nullable();
            $table->string('derotation')->nullable();
            $table->string('long_axis')->nullable();
            $table->string('crossbite')->nullable();
            $table->string('intrusion')->nullable();
            $table->string('extrusion')->nullable();
            $table->string('rotation_aligner')->nullable();
            $table->string('translation_aligner')->nullable();
            $table->string('intrusion_extrusion_aligner')->nullable();
            $table->string('sequential_distalization_mesialisation')->nullable();
            $table->string('same_number_aligners_for_both_arches')->nullable();
            $table->string('same_number_aligners_type')->nullable();
            $table->string('en_masse_distalization')->nullable();
            $table->string('ipr_preference')->nullable();
            $table->decimal('ipr_max_limit', 4, 2)->nullable();
            $table->text('additional_comments')->nullable();
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unique('doctor_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_clinical_preferences');
    }
};
