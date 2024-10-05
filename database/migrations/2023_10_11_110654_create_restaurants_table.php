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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('type');
            $table->string('country');
            $table->string('state');
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('address');
            $table->string('description');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->text('map')->nullable();
            $table->boolean('status')->default(false);
            $table->integer('register_status')->default(0);
            $table->integer('popular_count')->default(0); // 新增 popular_count 列
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};





