<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permohonan_58a', function (Blueprint $table) {
            $table->id();

            // Bahagian A - Maklumat Pemohon
            $table->string('nama')->nullable();
            $table->string('no_telefon')->nullable();
            $table->string('email')->nullable();
            $table->string('no_kp')->nullable();
            $table->string('jawatan')->nullable();
            $table->string('nama_syarikat')->nullable();
            $table->string('no_pendaftaran_cukai')->nullable();
            $table->date('tarikh_permohonan')->nullable();
            $table->string('no_kelulusan')->nullable();
            $table->string('no_pesanan_belian')->nullable();
            $table->text('alamat')->nullable();
            $table->string('negeri')->nullable();

            // Bahagian B - Orang yang menandatangani sijil
            $table->string('tandatangan_nama')->nullable();
            $table->string('tandatangan_no_kp')->nullable();
            $table->string('tandatangan_jawatan')->nullable();

            // Bahagian C - Pembekal
            $table->string('pembekal_nama')->nullable();
            $table->text('pembekal_alamat')->nullable();

            // Bahagian D - Perihal barangan (simpan sebagai JSON)
            $table->json('barangs')->nullable();

            // Lampiran (boleh banyak fail) disimpan sebagai JSON array (public disk)
            $table->json('attachments')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permohonan_58a');
    }
};
