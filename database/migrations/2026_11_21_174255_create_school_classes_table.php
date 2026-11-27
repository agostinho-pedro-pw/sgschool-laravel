<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->string('className', 20);

            $table->foreignId('course_id')
                ->constrained('courses')
                ->restrictOnDelete();

            $table->string('period', 10);

            $table->foreignId('room_id')
                ->nullable()
                ->constrained('rooms', 'id_sala')
                ->nullOnDelete();

            $table->foreignId('class_level_id')
                ->nullable()
                ->constrained('class_levels', 'classLevelId')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_classes');
    }
};
