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
        Schema::table('admission_payments', function (Blueprint $table) {
            $table->string('order_id')->nullable();
            $table->string('rrr')->nullable();
            $table->string('payment_gateway');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admission_payments', function (Blueprint $table) {
            $table->dropColumn([
                'order_id',
                'rrr',
                'payment_gateway'
            ]);
        });
    }
};
