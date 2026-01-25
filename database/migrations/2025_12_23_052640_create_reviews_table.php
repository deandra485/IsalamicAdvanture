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
        Schema::create('reviews', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('mountain_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('rating');
            $table->text('komentar')->nullable();
            $table->json('photos')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('photos');
        });
    }
};
