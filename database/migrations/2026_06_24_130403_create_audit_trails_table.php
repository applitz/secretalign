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
        Schema::create('audit_trails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('treatment_plan_id')->nullable();
            $table->string('event');
            $table->enum('from', ['D', 'S', 'L'])->nullable()->comment('D For Doctor, S for Staff, L for Lab');
            $table->enum('to', ['D', 'S', 'L'])->nullable()->comment('D For Doctor, S for Staff, L for Lab');
            $table->text('data');
            $table->text('url')->nullable();;
            $table->string('ip')->nullable();;
            $table->string('agent')->nullable();;
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
        Schema::dropIfExists('audit_trails');
    }
};
