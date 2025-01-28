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
        Schema::create('class_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('from')->default(0);
            $table->integer('to')->default(0);
            $table->boolean('has_meals')->default(false);
            $table->boolean('has_subjects')->default(false);
            $table->boolean('has_nap')->default(false);
            $table->boolean('has_toilet')->default(false);
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('nursery_id')->constrained('nurseries');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_rooms');
    }
};
