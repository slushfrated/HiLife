<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('titles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('color')->default('#654D48'); // Default text color
            $table->foreignId('achievement_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('user_titles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('title_id')->constrained()->onDelete('cascade');
            $table->boolean('is_selected')->default(false);
            $table->timestamps();
        });

        // Add current_title_achievement_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('current_title_achievement_id')->nullable()->after('profile_picture')
                ->constrained('achievements')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['current_title_achievement_id']);
            $table->dropColumn('current_title_achievement_id');
        });
        Schema::dropIfExists('user_titles');
        Schema::dropIfExists('titles');
    }
}; 