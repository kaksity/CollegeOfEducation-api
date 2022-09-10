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
        Schema::table('nce_application_statuses', function (Blueprint $table) {
            $table->uuid('academic_session_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nce_application_statuses', function (Blueprint $table) {
            $table->dropColumn('academic_session_id');
        });
    }
};
