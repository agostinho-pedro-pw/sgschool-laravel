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
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->string('nomeTurma');
            $table->string('classe', 20);
            $table->foreignId('course_id')
                ->constrained('courses')
                ->restrictOnDelete();
            $table->string('periodo', 10);
            $table->foreignId('room_id')
                ->nullable()
                ->constrained('rooms', 'id_sala')
                ->nullOnDelete();
            $table->foreignId('class_level_id')
                ->nullable()
                ->constrained('classes', 'id_classe')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_classes');
    }
};
