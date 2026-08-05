<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nama_syarikat',
        'login_id', // Masukkan login_id
        'role',     // Masukkan role
        'avatar_path',
        'password',
    ];

    /**
     * Get the normalized role used by the application UI and routing.
     */
    public function normalizedRole(): string
    {
        return $this->role;
    }

    /**
     * Get the human-readable label for the user's role.
     */
    public function roleLabel(): string
    {
        return match ($this->role) {
            'syarikat' => 'PEMOHON',
            'jkdm' => 'PEGAWAI VERIFIKASI',
            'ketua_unit_jkdm' => 'PEGAWAI PENYOKONG',
            'pelulus' => 'PEGAWAI PELULUS',
            'admin' => 'ADMIN',
            default => strtoupper(str_replace('_', ' ', $this->role)),
        };
    }

    /**
     * Get the avatar URL for the user, or the default avatar when none exists.
     */
    public function avatarUrl(): string
    {
        if ($this->avatar_path) {
            return asset('storage/'.$this->avatar_path);
        }

        return $this->usesCustomKastamAvatar()
            ? asset('images/kastam-diraja-malaysia-seeklogo.png')
            : asset('images/default-user-avatar.svg');
    }

    /**
     * Determine whether the user should use the Kastam default avatar.
     */
    public function usesCustomKastamAvatar(): bool
    {
        return in_array($this->role, ['admin', 'jkdm', 'ketua_unit_jkdm', 'pelulus'], true);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
