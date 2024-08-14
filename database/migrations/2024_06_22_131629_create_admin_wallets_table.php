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
        Schema::create('admin_wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('type_id'); // Changed to unsignedInteger for consistency
            $table->string('type_name');
            $table->string('type_category');
            $table->decimal('user_deposit', 15, 2)->default(0);
            $table->decimal('tax', 15, 2)->default(0);
            $table->decimal('balance', 15, 2)->default(0);
            $table->unsignedTinyInteger('transferred_status')->default(0); // Changed column name to lowercase for consistency
            $table->decimal('refund_user_deposit', 15, 2)->default(0);
            $table->decimal('refund_user_balance', 15, 2)->default(0);
            $table->decimal('user_cancel_balance', 15, 2)->default(0);
            $table->string('verify_code')->nullable();
            $table->timestamps();

            // Add indexes if needed
            $table->index('type_id');
            $table->index('transferred_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_wallets');
    }
};


