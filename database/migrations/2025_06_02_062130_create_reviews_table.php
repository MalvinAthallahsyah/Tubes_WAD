<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->foreignId('seller_id')->nullable()->constrained('sellers')->onDelete('cascade');
            $table->unsignedTinyInteger('rating'); // e.g., 1-5
            $table->text('comment')->nullable();
            $table->timestamps();

            // Optional: Index for querying reviews by product or seller
            $table->index(['product_id', 'seller_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};