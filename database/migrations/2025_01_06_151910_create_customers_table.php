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
			$table->date('birthday')->useCurrent();
			$table->date('idCardExp')->useCurrent();
			$table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('shop_id')->nullable()->constrained();
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
