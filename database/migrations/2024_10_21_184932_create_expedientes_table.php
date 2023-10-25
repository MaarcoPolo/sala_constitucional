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
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id();
            $table->integer('expediente');
            $table->integer('ayo');
            $table->date('fecha');
            $table->string('actor');
            $table->string('demandado');
            $table->string('archivo')->nullable();
            $table->foreignId('juicio_id')->constrained();
            $table->foreignId('ponencia_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes');
    }
};
