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
        Schema::create('booking_resorts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('user_name');
            $table->unsignedBigInteger('resort_id');
            $table->string('resort_name');
            $table->string('gender');
            $table->integer('quantity');
            $table->unsignedInteger('booking_days');
            $table->date('checkin_date');
            $table->date('checkout_date');
            $table->time('checkin_time');
            $table->time('checkout_time');
            $table->string('verify_code')->nullable();
            $table->unsignedTinyInteger('payment_status')->default(0);
            $table->unsignedDecimal('deposit_price', 10, 2)->default(0);
            $table->unsignedDecimal('total_price', 10, 2)->default(0);
            $table->string('card_number')->nullable();
            $table->string('card_holder');
            $table->unsignedTinyInteger('card_month');
            $table->unsignedSmallInteger('card_year');
            $table->string('cvv')->nullable();
            $table->integer('popular_count')->default(0);
            $table->timestamps();

            // 添加索引
            $table->index('user_id');
            $table->index('resort_id');

            // 添加外键约束
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('resort_id')->references('id')->on('resorts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_resorts');
    }
};




