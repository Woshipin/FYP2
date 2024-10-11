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
        Schema::create('reply_restaurant_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('comment_id');
            $table->integer('user_id')->nullable();
            $table->string('name');
            $table->text('reply');
            $table->integer('parent_id')->nullable(); // 添加 parent_id 字段
            $table->string('parent_type')->nullable(); // 添加 parent_type 字段
            $table->string('parent_name')->nullable(); // 添加 parent_name 字段
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reply_restaurant_comments');
    }
};
