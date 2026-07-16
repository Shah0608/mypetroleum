<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan58A extends Model
{
    use HasFactory;

    protected $table = 'permohonan_58a';

    protected $casts = [
        'barangs' => 'array',
        'attachments' => 'array',
        'tarikh_permohonan' => 'date',
    ];

    protected $fillable = [
        'nama', 'no_telefon', 'email', 'no_kp', 'jawatan', 'nama_syarikat', 'no_pendaftaran_cukai',
        'tarikh_permohonan', 'no_kelulusan', 'no_pesanan_belian', 'alamat', 'negeri',
        'tandatangan_nama', 'tandatangan_no_kp', 'tandatangan_jawatan',
        'pembekal_nama', 'pembekal_alamat', 'barangs', 'attachments'
    ];
}
