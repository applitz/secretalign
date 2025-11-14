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
        Schema::create('medit_links', function (Blueprint $table) {
            $table->id();
            $table->text('medit_link_group_uuid');
            $table->text('medit_link_access_token');
            $table->text('medit_link_refresh_token');
            $table->integer('user_id');

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
        Schema::dropIfExists('medit_links');
    }
};
