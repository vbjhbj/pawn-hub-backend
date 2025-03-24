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
            $table->text('description');
            $table->string('img')->default('');
			$table->foreignId('loan_id')->nullable()->constrained()->onDelete('set null');
			$table->foreignId('shop_id')->constrained();
			$table->foreignId('type_id')->constrained();
			$table->integer('estimatedValue');
			$table->integer('payedValue');
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
