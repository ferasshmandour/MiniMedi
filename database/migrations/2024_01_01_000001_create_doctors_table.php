<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('specialization', 255);
            $table->string('license_number', 50)->unique();
            $table->string('department', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->time('available_from')->default('09:00:00');
            $table->time('available_to')->default('17:00:00');
            $table->text('bio')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('specialization');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
