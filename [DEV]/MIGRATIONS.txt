<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
		Schema::dropIfExists('failed_jobs');
		Schema::dropIfExists('password_reset_tokens');
		Schema::dropIfExists('personal_access_tokens');
		Schema::dropIfExists('users');
        Schema::dropIfExists('deletedusers');
		Schema::dropIfExists('shops');
		Schema::dropIfExists('customers');
		Schema::dropIfExists('loans');
		Schema::dropIfExists('transactions');
		Schema::dropIfExists('messages');
		Schema::dropIfExists('types');
		Schema::dropIfExists('typeGroups');
		Schema::dropIfExists('items');
		Schema::dropIfExists('reviews');
		Schema::dropIfExists('holdings');
		Schema::dropIfExists('settlements');
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('username');
			$table->string('Password');
			$table->timestamp('lastTransaction')->useCurrent();
			$table->string('taxId');
			$table->string('iban');
			$table->string('imgUrl');
			$table->timestamps();
		});
		Schema::create('shops', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('taxId');
			$table->string('iban');
			$table->string('mobile');
			$table->string('email');
			$table->foreignId('user_id')->constrained();
			$table->integer('estYear');
			$table->foreignId('settlementId')->constrained();
			$table->timestamps();
		});
		Schema::create('customers', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('idCardNum');
			$table->timestamp('birthday')->useCurrent();
			$table->timestamp('idCardExp')->useCurrent();
			$table->foreignId('user_id')->constrained();
			$table->string('bankCardNum');
			$table->string('bankCardExpDate');
			$table->string('bankCardName');
			$table->string('shippingAddress');
			$table->string('billingAddress');
			$table->string('mobile');
			$table->string('email');
			$table->timestamps();
		});
		Schema::create('reviews', function (Blueprint $table) {
			$table->id();
			$table->foreignId('customer_id')->constrained();
			$table->foreignId('shop_id')->constrained();
			$table->tinyInteger('rating');
			$table->text('review');
			$table->integer('likes');
			$table->timestamps();
		});

		Schema::create('deletedUsers', function (Blueprint $table) {
			$table->id();
			$table->timestamp('lastTransaction')->useCurrent();
			$table->string('iban');
			$table->string('name');
            $table->timestamps();
        });
		Schema::create('loans', function (Blueprint $table) {
			$table->id();
			$table->foreignId('customer_id')->constrained();
			$table->foreignId('shop_id')->constrained();
			$table->timestamp('expDate')->useCurrent();
			$table->integer('givenAmount');
			$table->float('interest', precision:8);
			$table->timestamps();
        });
		
		Schema::create('transactions', function (Blueprint $table) {
			$table->id();
			$table->foreignId('shop_id')->constrained();
			$table->foreignId('customer_id')->constrained();
			$table->string('item');
			$table->integer('money');
			$table->timestamps();
        });
		
		Schema::create('messages', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('sender');
    		$table->foreign('sender')->references('id')->on('users');
			$table->string('subject');
			$table->string('message');
			$table->unsignedBigInteger('recipient');
    		$table->foreign('recipient')->references('id')->on('users');
			$table->timestamps();
        });
		Schema::create('typeGroups', function (Blueprint $table) {
			$table->id();
			$table->string('name');
        });
		
		Schema::create('types', function (Blueprint $table) {
			$table->id();
			$table->foreignId('typeGroup_id')->constrained();
			$table->string('name');
        });
		Schema::create('items', function (Blueprint $table) {
			$table->id();
			$table->string('imgUrl');
			$table->foreignId('loan_id')->constrained();
			$table->foreignId('shop_id')->constrained();
			$table->foreignId('type_id')->constrained();
			$table->integer('value');
        });
		Schema::create('holdings', function (Blueprint $table) {
			$table->id();
			$table->string('name');
        });
		Schema::create('settlements', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('postalCodes');
			$table->foreignId('holding_id')->constrained();
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('users');
	    Schema::drop('deletedUsers');
		Schema::dropIfExists('failed_jobs');
		Schema::dropIfExists('password_reset_tokens');
		Schema::dropIfExists('personal_access_tokens');
		Schema::dropIfExists('users');
        Schema::dropIfExists('deletedusers');
		Schema::dropIfExists('shops');
		Schema::dropIfExists('customers');
		Schema::dropIfExists('loans');
		Schema::dropIfExists('transactions');
		Schema::dropIfExists('messages');
		Schema::dropIfExists('types');
		Schema::dropIfExists('typeGroups');
		Schema::dropIfExists('items');
		Schema::dropIfExists('reviews');
		Schema::dropIfExists('holdings');
		Schema::dropIfExists('settlements');
    }
};