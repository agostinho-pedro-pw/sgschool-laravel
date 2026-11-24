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
        Schema::create('departments', function (Blueprint $table) {
            // Chave primária do departamento: department_id
            $table->id('department_id');
            // Nome do departamento (ex.: Ciências Informáticas)
            $table->string('department_name');
            // Código curto do departamento (ex.: CI)
            $table->string('department_code', 20);
            // Descrição livre do departamento
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
