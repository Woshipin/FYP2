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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('refund_name');
            $table->string('type_name');
            $table->decimal('deposit_price');
            $table->string('user_card_number');
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
        Schema::dropIfExists('refunds');
    }
};
