<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catatan_bimbingans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bimbingan_id')->constrained('bimbingans')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('kategori', ['revisi', 'saran', 'progress']);
            $table->text('isi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catatan_bimbingans');
    }
};
