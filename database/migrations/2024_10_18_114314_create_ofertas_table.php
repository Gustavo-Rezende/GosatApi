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
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->string('cpf');
            $table->string('instituicao');
            $table->string('modalidade');
            $table->integer('QntParcelaMin');
            $table->integer('QntParcelaMax');
            $table->decimal('valorMin', 10, 2);
            $table->decimal('valorMax', 10, 2);
            $table->decimal('jurosMes', 5, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};
