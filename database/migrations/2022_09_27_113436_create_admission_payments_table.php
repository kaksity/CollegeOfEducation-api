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
        Schema::create('admission_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('course_group_id')->index();
            $table->uuid('user_id')->index();
            $table->string('reference_code')->nullable();
            $table->decimal('amount');
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('admission_payments');
    }
};
