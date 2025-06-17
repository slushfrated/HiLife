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
        Schema::create('avatar_frames', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_path');
            $table->text('description')->nullable();
            $table->foreignId('achievement_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('user_avatar_frames', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('avatar_frame_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_avatar_frames');
        Schema::dropIfExists('avatar_frames');
    }
}; 