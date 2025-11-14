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
        Schema::table('p_treatment_plans', function (Blueprint $table) {
            $table->text('add_pontic_ur')->after('ctp_ll')->nullable();
            $table->text('add_pontic_ul')->after('add_pontic_ur')->nullable();
            $table->text('add_pontic_lr')->after('add_pontic_ul')->nullable();
            $table->text('add_pontic_ll')->after('add_pontic_lr')->nullable();
            $table->text('add_bite_turbos_ur')->after('add_pontic_ll')->nullable();
            $table->text('add_bite_turbos_ul')->after('add_bite_turbos_ur')->nullable();
            $table->text('add_bite_turbos_lr')->after('add_bite_turbos_ul')->nullable();
            $table->text('add_bite_turbos_ll')->after('add_bite_turbos_lr')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p_treatment_plans', function (Blueprint $table) {
            $table->dropColumn([
                'add_pontic_ur',
                'add_pontic_ul',
                'add_pontic_lr',
                'add_pontic_ll',
                'add_bite_turbos_ur',
                'add_bite_turbos_ul',
                'add_bite_turbos_lr',
                'add_bite_turbos_ll',
            ]);
        });
    }
};
