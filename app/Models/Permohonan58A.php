<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permohonan58A extends Model
{
    use HasFactory;

    protected $table = 'permohonan_58a';

    protected $casts = [
        'barangs' => 'array',
        'attachments' => 'array',
        'tarikh_permohonan' => 'date',
        'tarikh_diluluskan' => 'date',
        'tarikh_tamat' => 'date',
        'tarikh_ulasan_jkdm' => 'date',
        'tarikh_tamat_cga' => 'date',
    ];

    protected $fillable = [
        'user_id', 'nama', 'no_telefon', 'email', 'no_kp', 'jawatan', 'nama_syarikat', 'no_pendaftaran_cukai',
        'tarikh_permohonan', 'no_kelulusan', 'no_pesanan_belian', 'alamat', 'negeri',
        'tandatangan_nama', 'tandatangan_no_kp', 'tandatangan_jawatan',
        'pembekal_nama', 'pembekal_alamat', 'barangs', 'attachments', 'status', 'no_sijil_pengecualian',
        'tarikh_diluluskan', 'tarikh_tamat', 'sijil_pengecualian_path', 'ulasan_jkdm', 'nama_pegawai_jkdm', 'tarikh_ulasan_jkdm',
        'tarikh_tamat_cga',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
