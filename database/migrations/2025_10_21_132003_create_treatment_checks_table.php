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
        Schema::create('treatment_checks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->boolean('attachments_model')->default(false);
            $table->boolean('bars_model')->default(false);
            $table->boolean('name_patient')->default(false);
            $table->boolean('model_dashboard')->default(false);
            $table->boolean('cutouts_hooks')->default(false);
            $table->boolean('schnittlinie')->default(false);
            $table->boolean('zahlen_vergleichen')->default(false);
            $table->boolean('cutouts_schiene')->default(false);
            $table->boolean('folie_runtergenommen')->default(false);
            $table->boolean('richtig_einpacken')->default(false);
            $table->boolean('richtiger_asr')->default(false);
            $table->string('coworker_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('treatment_checks');
    }
};
