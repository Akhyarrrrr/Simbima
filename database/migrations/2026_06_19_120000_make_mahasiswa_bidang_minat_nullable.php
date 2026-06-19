<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->foreignId('bidang_minat_id')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->foreignId('bidang_minat_id')
                ->nullable(false)
                ->change();
        });
    }
};
