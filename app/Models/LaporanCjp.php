<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanCjp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'permohonan_58a_id', 'negeri', 'nama_syarikat', 'tahun', 'bulan',
        'no_sijil_pengecualian', 'tarikh_sah_laku_sijil', 'tarikh_tamat_sijil', 'pembekal_nama',
        'kod_tarif_barang', 'perihal_barang', 'unit', 'kuantiti_diluluskan', 'baki_kuantiti_diluluskan',
        'baki_awal', 'baki_akhir', 'pembelians', 'penjualans', 'nama_penuh', 'jawatan', 'no_telefon', 'fail_path',
    ];

    protected function casts(): array
    {
        return [
            'tarikh_sah_laku_sijil' => 'date',
            'tarikh_tamat_sijil' => 'date',
            'pembelians' => 'array',
            'penjualans' => 'array',
            'kuantiti_diluluskan' => 'decimal:3',
            'baki_kuantiti_diluluskan' => 'decimal:3',
            'baki_awal' => 'decimal:3',
            'baki_akhir' => 'decimal:3',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan58A::class, 'permohonan_58a_id');
    }
}
