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
        Schema::table('laporan_cjps', function (Blueprint $table): void {
            $table->foreignId('permohonan_58a_id')->nullable()->after('user_id')->constrained('permohonan_58a')->nullOnDelete();
            $table->string('no_sijil_pengecualian')->nullable()->after('bulan');
            $table->date('tarikh_sah_laku_sijil')->nullable()->after('no_sijil_pengecualian');
            $table->date('tarikh_tamat_sijil')->nullable()->after('tarikh_sah_laku_sijil');
            $table->string('pembekal_nama')->nullable()->after('tarikh_tamat_sijil');
            $table->string('kod_tarif_barang')->nullable()->after('pembekal_nama');
            $table->string('perihal_barang')->nullable()->after('kod_tarif_barang');
            $table->string('unit')->nullable()->after('perihal_barang');
            $table->decimal('kuantiti_diluluskan', 18, 3)->default(0)->after('unit');
            $table->decimal('baki_kuantiti_diluluskan', 18, 3)->default(0)->after('kuantiti_diluluskan');
            $table->decimal('baki_awal', 18, 3)->default(0)->after('baki_kuantiti_diluluskan');
            $table->decimal('baki_akhir', 18, 3)->default(0)->after('baki_awal');
            $table->json('pembelians')->nullable()->after('baki_akhir');
            $table->json('penjualans')->nullable()->after('pembelians');
            $table->string('nama_penuh')->nullable()->after('penjualans');
            $table->string('jawatan')->nullable()->after('nama_penuh');
            $table->string('no_telefon')->nullable()->after('jawatan');
            $table->index('permohonan_58a_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_cjps', function (Blueprint $table): void {
            $table->dropForeign(['permohonan_58a_id']);
            $table->dropIndex(['permohonan_58a_id']);
            $table->dropColumn([
                'permohonan_58a_id', 'no_sijil_pengecualian', 'tarikh_sah_laku_sijil', 'tarikh_tamat_sijil',
                'pembekal_nama', 'kod_tarif_barang', 'perihal_barang', 'unit', 'kuantiti_diluluskan',
                'baki_kuantiti_diluluskan', 'baki_awal', 'baki_akhir', 'pembelians', 'penjualans',
                'nama_penuh', 'jawatan', 'no_telefon',
            ]);
        });
    }
};
