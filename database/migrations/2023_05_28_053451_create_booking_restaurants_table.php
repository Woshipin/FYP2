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
        Schema::create('booking_restaurants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('user_name');
            $table->unsignedBigInteger('restaurant_id');
            $table->string('restaurant_name');
            $table->integer('table_id');
            $table->string('gender');
            $table->integer('quantity');
            $table->date('booking_date');
            $table->time('checkin_time');
            $table->time('checkout_time');
            $table->string('verify_code')->nullable();
            $table->unsignedTinyInteger('payment_status')->default(0);
            $table->unsignedDecimal('deposit_price', 10, 2)->default(0);
            $table->string('card_number'); // 更改数据类型为 string
            $table->string('card_holder');
            $table->unsignedTinyInteger('card_month'); // 存储月份的整数
            $table->unsignedSmallInteger('card_year'); // 存储年份的整数
            $table->string('cvv');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_restaurants');
    }
};
