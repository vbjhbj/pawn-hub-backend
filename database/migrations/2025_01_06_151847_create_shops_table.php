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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
			$table->string('taxId');
			$table->string('mobile')->nullable();
            $table->string('website')->nullable();
			$table->foreignId('user_id')->constrained();
			$table->integer('estYear')->nullable();
			$table->foreignId('settlement_id')->constrained();
            $table->string('address');
            $table->string('intro')->nullable();
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
        Schema::dropIfExists('shops');
    }
};
