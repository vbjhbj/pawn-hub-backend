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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->longText('location')->nullable();
            $table->longText('img')->nullable();
			$table->foreignId('loan_id')->nullable()->constrained()->onDelete('set null');
			$table->foreignId('shop_id')->constrained();
			$table->foreignId('type_id')->constrained();
			$table->integer('estimatedValue');
			$table->integer('payedValue');
			$table->integer('condition');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
