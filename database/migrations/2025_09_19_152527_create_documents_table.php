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
            $table->string('title');              // Nama dokumen
            $table->string('category');           // Jenis (Kontrak, Perjanjian, dll)
            $table->string('related_party')->nullable(); // Pihak terkait
            $table->date('date')->nullable();     // Tanggal dokumen
            $table->string('file_path');          // Lokasi file
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
