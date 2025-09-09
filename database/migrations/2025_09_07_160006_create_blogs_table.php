<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('likes_count')->default(0);
            $table->timestamps();
            
            $table->index(['created_at', 'likes_count']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};