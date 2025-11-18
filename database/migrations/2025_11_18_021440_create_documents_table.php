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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            // El documento pertenece a un tomo
            $table->foreignId('tomo_id')->constrained()->cascadeOnDelete();

            // Opcional: Serie documental (puede venir del tomo, pero lo dejamos explícito)
            $table->foreignId('document_series_id')
                  ->nullable()
                  ->constrained('document_series')
                  ->nullOnDelete();

            // Datos del documento
            $table->string('number');         // Nº de resolución, acuerdo, etc.
            $table->date('date')->nullable(); // Fecha del documento
            $table->text('summary')->nullable(); // Asunto / descripción corta

            // Nº de folios internos del documento (hojas físicas de ese expediente)
            $table->unsignedInteger('pages')->nullable();

            // Archivo digital (PDF/imagen)
            $table->string('pdf_path')->nullable();

            // Correlativo dentro del tomo (folio de archivo)
            $table->unsignedInteger('folio_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
