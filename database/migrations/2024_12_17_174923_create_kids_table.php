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
        Schema::create('kids', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->enum('gender', ['boy', 'girl']);
            $table->boolean('has_medical_case')->default(false);
            $table->longText('description_medical_case')->nullable();
            $table->foreignId('parent_id')->constrained('parent_kids')->cascadeOnDelete();
            $table->foreignId('class_room_id')->constrained('class_rooms');
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
        Schema::dropIfExists('kids');
    }
};
