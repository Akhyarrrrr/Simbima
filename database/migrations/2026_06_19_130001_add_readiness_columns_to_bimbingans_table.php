<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bimbingans', function (Blueprint $table) {
            $table->boolean('boleh_sempro')->default(false)->after('status');
            $table->boolean('boleh_semhas')->default(false)->after('boleh_sempro');
            $table->boolean('boleh_sidang')->default(false)->after('boleh_semhas');
        });
    }

    public function down(): void
    {
        Schema::table('bimbingans', function (Blueprint $table) {
            $table->dropColumn(['boleh_sempro', 'boleh_semhas', 'boleh_sidang']);
        });
    }
};
