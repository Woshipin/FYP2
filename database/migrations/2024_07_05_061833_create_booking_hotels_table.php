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
        Schema::create('booking_hotels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('user_name');
            $table->unsignedBigInteger('hotel_id');
            $table->string('hotel_name');
            $table->integer('room_id');
            $table->string('gender');
            $table->integer('quantity');
            $table->unsignedInteger('booking_days'); // 使用无符号整数类型保存天数
            $table->date('checkin_date');
            $table->date('checkout_date');
            $table->time('checkin_time');
            $table->time('checkout_time');
            $table->string('verify_code')->nullable();
            $table->unsignedTinyInteger('payment_status')->default(0);
            $table->string('payment_method')->nullable(); 
            $table->unsignedDecimal('deposit_price', 10, 2)->default(0);
            $table->unsignedDecimal('total_price', 10, 2)->default(0);
            $table->string('card_number'); // 更改数据类型为 string
            $table->string('card_holder');
            $table->unsignedTinyInteger('card_month'); // 存储月份的整数
            $table->unsignedSmallInteger('card_year'); // 存储年份的整数
            $table->string('cvv');
            $table->integer('popular_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_hotels');
    }
};


