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
        'tarikh_ulasan_verifikasi' => 'date',
        'tarikh_tamat_pda2_verifikasi' => 'date',
        'tarikh_ulasan_ketua_unit' => 'date',
        'tarikh_tamat_pda2_ketua_unit' => 'date',
        'jkdm_notified_at' => 'datetime',
    ];

    protected $fillable = [
        'user_id', 'nama', 'no_telefon', 'email', 'no_kp', 'jawatan', 'nama_syarikat', 'no_pendaftaran_cukai',
        'tarikh_permohonan', 'no_kelulusan', 'no_pesanan_belian', 'alamat', 'negeri',
        'tandatangan_nama', 'tandatangan_no_kp', 'tandatangan_jawatan',
        'pembekal_nama', 'pembekal_alamat', 'barangs', 'attachments', 'status', 'no_sijil_pengecualian',
        'tarikh_diluluskan', 'tarikh_tamat', 'sijil_pengecualian_path', 'ulasan_jkdm', 'nama_pegawai_jkdm', 'tarikh_ulasan_jkdm',
        'tarikh_tamat_cga', 'ulasan_pegawai_verifikasi', 'nama_pegawai_verifikasi', 'tarikh_ulasan_verifikasi', 'tarikh_tamat_pda2_verifikasi',
        'ulasan_ketua_unit', 'nama_pegawai_ketua_unit', 'tarikh_ulasan_ketua_unit', 'tarikh_tamat_pda2_ketua_unit', 'jkdm_notified_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTempohHariAttribute(): ?int
    {
        if (! $this->tarikh_diluluskan || ! $this->tarikh_tamat) {
            return null;
        }

        return $this->tarikh_diluluskan->startOfDay()->diffInDays($this->tarikh_tamat->startOfDay());
    }

    public function getBakiHariAttribute(): ?int
    {
        if (! $this->tarikh_tamat) {
            return null;
        }

        return now()->startOfDay()->diffInDays($this->tarikh_tamat->startOfDay(), false);
    }

    public function getTempohHariLabelAttribute(): string
    {
        if ($this->tempoh_hari === null) {
            return '-';
        }

        return $this->tempoh_hari.' hari';
    }

    public function getBakiHariLabelAttribute(): string
    {
        if ($this->baki_hari === null) {
            return '-';
        }

        if ($this->baki_hari < 0) {
            return 'Tamat '.$this->baki_hari.' hari lepas';
        }

        return 'Baki '.$this->baki_hari.' hari';
    }

    public function getTempohHariIndicatorClassAttribute(): string
    {
        if ($this->baki_hari === null) {
            return 'bg-slate-300 text-slate-700';
        }

        if ($this->baki_hari <= 0) {
            return 'bg-red-100 text-red-700 ring-red-200';
        }

        if ($this->tempoh_hari !== null && $this->baki_hari <= (int) ceil($this->tempoh_hari / 2)) {
            return 'bg-yellow-100 text-yellow-800 ring-yellow-200';
        }

        return 'bg-emerald-100 text-emerald-700 ring-emerald-200';
    }

    public function getTempohHariIndicatorLabelAttribute(): string
    {
        if ($this->baki_hari === null) {
            return '-';
        }

        if ($this->baki_hari <= 0) {
            return 'Tamat Tempoh';
        }

        if ($this->tempoh_hari !== null && $this->baki_hari <= (int) ceil($this->tempoh_hari / 2)) {
            return 'Pemantauan Pegawai';
        }

        return 'Masih Berkuatkuasa';
    }
}
