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
        Schema::create('course_registeration_cards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('academic_session_id')->index();
            $table->uuid('course_group_id')->index();
            $table->string('serial_number');
            $table->string('pin');
            $table->integer('used_counter')->default(0);
            $table->string('status')->default('active');
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
        Schema::dropIfExists('course_registeration_cards');
    }
};
