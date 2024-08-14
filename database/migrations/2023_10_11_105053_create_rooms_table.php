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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id(); // 自增主键
            $table->unsignedBigInteger('user_id')->nullable(); // 无符号大整数，用于关联用户表
            $table->unsignedBigInteger('hotel_id'); // 无符号大整数，用于关联餐厅表
            $table->string('name'); // 字符串类型的名称
            $table->string('type'); // 字符串类型的类型
            $table->integer('available'); // 整数类型的字段，标识可用性，你也可以使用 boolean 类型，取决于你的设计。
            $table->decimal('price', 10, 2); // 十位数字，小数点后两位，用于存储价格
            $table->boolean('status')->default(false);
            $table->timestamps(); // 自动生成 created_at 和 updated_at 时间戳字段
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
