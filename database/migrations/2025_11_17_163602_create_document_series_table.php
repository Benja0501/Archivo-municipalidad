<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_series', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // ej: "ADM-01"
            $table->string('name');               // ej: "Trámite documentario"
            $table->text('description')->nullable();
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('document_series')
                  ->nullOnDelete(); // subseries
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_series');
    }
};
