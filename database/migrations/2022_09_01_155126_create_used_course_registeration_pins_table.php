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
        Schema::create('used_course_registeration_pins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('academic_session_id')->index();
            $table->uuid('user_id')->index();
            $table->uuid('card_id')->index();
            $table->softDeletes();
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
        Schema::dropIfExists('used_course_registeration_pins');
    }
};
