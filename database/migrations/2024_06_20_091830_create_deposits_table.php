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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('user_email');
            $table->string('type_name');
            $table->unsignedDecimal('deposit_price', 10, 2)->default(0); // 定义小数精度为10位，总数
            $table->unsignedDecimal('total_price', 10, 2)->default(0);
            $table->string('card_number'); // 只存储卡号的最后四位
            $table->string('card_holder');
            $table->unsignedTinyInteger('card_month'); // 存储月份的整数
            $table->unsignedSmallInteger('card_year'); // 存储年份的整数
            $table->string('cvv'); // 存储加密的CVV
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};



