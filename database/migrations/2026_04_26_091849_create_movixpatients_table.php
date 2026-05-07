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
        Schema::create('movixpatients', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id');
            $table->integer('p_treatment_plans_id');
            $table->text('case_id')->nullable();
            $table->text('client')->nullable();
            $table->text('note')->nullable();
            $table->longText('movix_note')->nullable();
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
        Schema::dropIfExists('movixpatients');
    }
};
