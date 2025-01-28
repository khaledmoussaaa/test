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
        Schema::create('kid_payment_bills', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['pending', 'review', 'accepted', 'rejected'])->default('pending');
            $table->foreignId('payment_bill_id')->constrained('payment_bills')->cascadeOnDelete();
            $table->foreignId('kid_id')->constrained('kids')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kid_payment_bills');
    }
};
