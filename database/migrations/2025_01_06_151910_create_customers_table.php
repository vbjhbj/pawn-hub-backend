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
			$table->foreignId('user_id')->constrained();
            $table->foreignId('shop_id')->constrained();
			$table->string('shippingAddress');
			$table->string('billingAddress');
			$table->string('mobile');
			$table->string('email');
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
