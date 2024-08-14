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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id(); // 自动增加的唯一标识符
            $table->unsignedBigInteger('user_id')->nullable();// 无符号大整数，用于关联用户
            $table->string('name'); // 字符串类型，用于存储酒店名称
            $table->string('image')->nullable(); ; // 字符串类型，用于存储图片的 URL
            $table->string('phone'); // 字符串类型，用于存储电话号码
            $table->string('email'); // 字符串类型，用于存储电子邮件地址
            $table->string('type');
            $table->string('country'); // 字符串类型，用于存储国家
            $table->string('state'); // 字符串类型，用于存储州/省
            $table->string('address'); // 字符串类型，用于存储地址
            $table->text('description'); // 文本类型，用于存储描述信息
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->text('map');
            $table->boolean('status')->default(false); // 布尔类型，表示状态，初始值为假（未激活）
            $table->integer('register_status')->default(0);
            $table->string('digital_lock_password')->nullable();
            $table->string('emailbox_password')->nullable();
            $table->timestamps(); // 自动管理创建时间和更新时间
            // 如果需要，添加外键约束
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
