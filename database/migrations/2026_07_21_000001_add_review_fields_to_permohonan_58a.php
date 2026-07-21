<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonan_58a', function (Blueprint $table): void {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            $table->string('status')->default('Dalam tindakan');
            $table->string('no_sijil_pengecualian')->nullable();
            $table->date('tarikh_diluluskan')->nullable();
            $table->date('tarikh_tamat')->nullable();
            $table->string('sijil_pengecualian_path')->nullable();
            $table->text('ulasan_jkdm')->nullable();
            $table->string('nama_pegawai_jkdm')->nullable();
            $table->date('tarikh_ulasan_jkdm')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('permohonan_58a', function (Blueprint $table): void {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'status', 'no_sijil_pengecualian', 'tarikh_diluluskan', 'tarikh_tamat', 'sijil_pengecualian_path', 'ulasan_jkdm', 'nama_pegawai_jkdm', 'tarikh_ulasan_jkdm']);
        });
    }
};
