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
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->boolean('is_private')->default(false);
            $table->integer('likes_count')->default(0);
            $table->foreignId('class_room_id')->nullable()->constrained('class_rooms');
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
        Schema::dropIfExists('newsletters');
    }
};
