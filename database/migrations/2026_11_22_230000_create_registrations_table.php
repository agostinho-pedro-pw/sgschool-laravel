<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('fullName')->nullable();
            $table->string('studentId')->nullable();
            $table->string('department')->nullable();
            $table->string('course')->nullable();
            $table->date('dateOfBirth')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('parentPhone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('schoolClass')->nullable();
            $table->string('academicYear', 20)->nullable();
            $table->string('room', 30)->nullable();
            $table->string('turno', 20)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
