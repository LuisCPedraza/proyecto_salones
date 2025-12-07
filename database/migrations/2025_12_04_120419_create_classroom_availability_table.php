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
        Schema::create('classroom_availability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');
            $table->integer('day_of_week'); // 0=Lunes, 1=Martes, ..., 5=Sábado
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['classroom_id', 'day_of_week', 'start_time', 'end_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classroom_availability');
    }
};
