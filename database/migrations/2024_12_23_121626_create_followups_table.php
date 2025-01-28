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
        Schema::create('followups', function (Blueprint $table) {
            $table->id();
            $table->string('napping')->default("0");
            $table->integer('daiper')->default(0);
            $table->integer('potty')->default(0);
            $table->integer('toilet')->default(0);
            $table->integer('moods')->nullable();
            $table->longText('comment')->nullable();
            $table->date('date');
            $table->foreignId('kid_id')->constrained('kids')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('nursery_id')->constrained('nurseries')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followups');
    }
};
