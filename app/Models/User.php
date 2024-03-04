<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'NIK',
        'name',
        'password',
        'role',
        'pw',
        'lokasi_id'
    ];

    public function getRedirectRoute()
    {
        switch ($this->role) {
            case 'admin':
                return 'staff.dashboard';
            case 'spv':
                return 'spv.dashboard';
            case 'user':
                return 'user.home';
        }
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }

    public function keranjang()
    {
        return $this->hasOne(Keranjang::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
