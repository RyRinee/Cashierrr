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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade'); // Links to transactions table
            $table->foreignId('menu_id')->constrained()->onDelete('cascade'); // Links to menus table
            $table->integer('quantity'); // Quantity of the menu item
            $table->decimal('price', 15, 2); // Price per unit
            $table->decimal('subtotal', 15, 2); // Subtotal (quantity * price)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
