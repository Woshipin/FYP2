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
        Schema::create('restaurant_communities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained('restaurants'); // Foreign key to resorts
            $table->string('name'); // Name of the community
            $table->text('image')->nullable(); // To store image paths (assuming images are stored on disk)
            $table->text('cultural')->nullable(); // Cultural information
            $table->text('address'); // Address (same as location in your form)
            $table->decimal('latitude', 10, 7)->nullable(); // Latitude
            $table->decimal('longitude', 10, 7)->nullable(); // Longitude
            $table->text('description'); // Description
            $table->string('category'); // Category field (e.g., transport, community, social, cultural)
            $table->timestamps(); // Created and updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_communities');
    }
};
