<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('courseCode', 50);
            $table->string('courseName');
            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments', 'department_id')
                ->nullOnDelete();
            $table->text('courseDescription')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
