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
        Schema::create('resort_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resort_id'); // Resort关联字段
            $table->integer('nights');
            $table->integer('discount');
            $table->timestamps();

            // 外键约束，确保resort_id引用合法的度假村
            $table->foreign('resort_id')->references('id')->on('resorts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resort_discounts');
    }
};
