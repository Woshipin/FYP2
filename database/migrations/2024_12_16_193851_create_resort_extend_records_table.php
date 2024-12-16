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
        Schema::create('resort_extend_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_resort_id');
            $table->date('checkin_date');
            $table->date('checkout_date');
            $table->json('extend_dates');
            $table->json('payment_information');
            $table->timestamps();

            $table->foreign('booking_resort_id')->references('id')->on('booking_resorts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resort_extend_records');
    }
};
