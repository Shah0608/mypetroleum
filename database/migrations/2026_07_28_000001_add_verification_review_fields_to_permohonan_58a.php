<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonan_58a', function (Blueprint $table): void {
            $table->text('ulasan_pegawai_verifikasi')->nullable()->after('tarikh_tamat_cga');
            $table->string('nama_pegawai_verifikasi')->nullable()->after('ulasan_pegawai_verifikasi');
            $table->date('tarikh_ulasan_verifikasi')->nullable()->after('nama_pegawai_verifikasi');
            $table->date('tarikh_tamat_pda2_verifikasi')->nullable()->after('tarikh_ulasan_verifikasi');

            $table->text('ulasan_ketua_unit')->nullable()->after('tarikh_tamat_pda2_verifikasi');
            $table->string('nama_pegawai_ketua_unit')->nullable()->after('ulasan_ketua_unit');
            $table->date('tarikh_ulasan_ketua_unit')->nullable()->after('nama_pegawai_ketua_unit');
            $table->date('tarikh_tamat_pda2_ketua_unit')->nullable()->after('tarikh_ulasan_ketua_unit');
        });
    }

    public function down(): void
    {
        Schema::table('permohonan_58a', function (Blueprint $table): void {
            $table->dropColumn([
                'ulasan_pegawai_verifikasi',
                'nama_pegawai_verifikasi',
                'tarikh_ulasan_verifikasi',
                'tarikh_tamat_pda2_verifikasi',
                'ulasan_ketua_unit',
                'nama_pegawai_ketua_unit',
                'tarikh_ulasan_ketua_unit',
                'tarikh_tamat_pda2_ketua_unit',
            ]);
        });
    }
};
