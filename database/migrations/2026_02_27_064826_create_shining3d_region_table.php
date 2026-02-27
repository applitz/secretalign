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
        Schema::create('shining3d_region', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Region name');
            $table->string('code')->comment('Region code');
            $table->string('description')->comment('Region description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Region status');
            $table->string('api_url')->comment('API URL for the region');
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
        Schema::dropIfExists('shining3d_region');
    }
};
