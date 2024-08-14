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
        Schema::create('resorts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('image')->nullable(); // Make 'image' column nullable
            $table->decimal('price', 10, 2); // 十位数字，小数点后两位，用于存储价格
            $table->string('phone');
            $table->string('email');
            $table->string('type');
            $table->string('country');
            $table->string('state');
            $table->string('location');
            $table->text('description');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->text('map');
            $table->boolean('status')->default(false);
            $table->integer('register_status')->default(0);
            $table->string('digital_lock_password')->nullable();
            $table->string('emailbox_password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resorts');
    }
};

