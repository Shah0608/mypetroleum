<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanCjp extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'negeri', 'nama_syarikat', 'tahun', 'bulan', 'fail_path'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
