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
        Schema::create('tomos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained()->cascadeOnDelete();

            // Opcional: vínculo con la serie documental ya creada
            $table->foreignId('document_series_id')
                ->nullable()
                ->constrained('document_series')
                ->nullOnDelete();

            $table->unsignedInteger('item');            // 69, 70, 71...
            $table->string('description');              // DESCRIPCIÓN DEL TOMO
            $table->integer('year');                    // 2010
            $table->unsignedInteger('tome_number');     // N° de tomo dentro de ese año/serie
            $table->string('folios')->nullable();       // "S/F" o número, según tu realidad

            $table->text('from_ref')->nullable();       // DESDE
            $table->text('to_ref')->nullable();         // HASTA

            $table->unsignedInteger('shelf_number');    // N° ANDAMIO
            $table->unsignedInteger('shelf_row');       // N° FILA

            $table->boolean('active')->default(true);
            $table->timestamps();
            // Índice útil para búsquedas
            $table->index(['area_id', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tomos');
    }
};
