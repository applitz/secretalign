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
        Schema::table('movixpatients', function (Blueprint $table) {
            $table->text('movix_link')->nullable()->after('movix_note');
            $table->timestamp('movix_link_expires_at')->after('movix_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movixpatients', function (Blueprint $table) {
            $table->dropColumn(['movix_link', 'movix_link_expires_at']);
        });
    }
};
