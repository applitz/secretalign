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
        Schema::table('audit_trails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('treatment_plan_id')->nullable();
            $table->string('event');
            $table->enum('from', ['D', 'S', 'L'])->nullable()->comment('D For Doctor, S for Staff, L for Lab');
            $table->enum('to', ['D', 'S', 'L'])->nullable()->comment('D For Doctor, S for Staff, L for Lab');
            $table->text('data');
            $table->text('url');
            $table->string('ip');
            $table->string('agent');
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
        Schema::table('audit_trails', function (Blueprint $table) {
            //
        });
    }
};
