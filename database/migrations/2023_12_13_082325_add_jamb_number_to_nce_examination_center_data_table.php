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
        Schema::table('nce_examination_center_data', function (Blueprint $table) {
            $table->string('jamb_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nce_examination_center_data', function (Blueprint $table) {
            $table->dropColumn([
                'jamb_number'
            ]);
        });
    }
};
