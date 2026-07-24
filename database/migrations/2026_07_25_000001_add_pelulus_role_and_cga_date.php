<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('syarikat', 'jkdm', 'admin', 'pelulus') NOT NULL DEFAULT 'syarikat'");
        }

        Schema::table('permohonan_58a', function (Blueprint $table): void {
            if (! Schema::hasColumn('permohonan_58a', 'tarikh_tamat_cga')) {
                $table->date('tarikh_tamat_cga')->nullable()->after('tarikh_ulasan_jkdm');
            }
        });
    }

    public function down(): void
    {
        Schema::table('permohonan_58a', function (Blueprint $table): void {
            $table->dropColumn('tarikh_tamat_cga');
        });

        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('syarikat', 'jkdm', 'admin') NOT NULL DEFAULT 'syarikat'");
        }
    }
};
