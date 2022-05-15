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
        Schema::create('dip_contact_data', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->string('name_of_guardian')->nullable();
            $table->string('address_of_guardian')->nullable();
            $table->string('name_of_employer')->nullable();
            $table->string('address_of_employer')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email_address');
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
        Schema::dropIfExists('dip_contact_data');
    }
};
