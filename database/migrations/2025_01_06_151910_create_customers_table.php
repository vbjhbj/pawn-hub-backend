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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
			$table->string('idCardNum');
			$table->timestamp('birthday')->useCurrent();
			$table->timestamp('idCardExp')->useCurrent();
			$table->foreignId('user_id')->constrained()->nullable();
            $table->foreignId('shop_id')->constrained()->nullable();
			$table->string('shippingAddress')->nullable();
			$table->string('billingAddress')->nullable();
			$table->string('mobile')->nullable();
			$table->string('email')->nullable();
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
        Schema::dropIfExists('customers');
    }
};
