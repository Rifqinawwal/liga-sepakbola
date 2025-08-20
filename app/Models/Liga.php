<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Liga extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'negara', 'logo', 'bendera'];

    /**
     * ===== PERINTAH UNTUK SELALU MENYERTAKAN URL YANG BENAR =====
     * Properti ini akan memaksa Laravel untuk selalu menyertakan
     * hasil dari getLogoUrlAttribute dan getBenderaUrlAttribute.
     */
    protected $appends = ['logo_url', 'bendera_url'];

    /**
     * Accessor untuk mendapatkan URL logo yang benar secara otomatis.
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            if (Str::startsWith($this->logo, 'logo_liga/')) {
                return asset('storage/' . $this->logo);
            }
            return asset($this->logo);
        }
        return null;
    }

    /**
     * Accessor untuk mendapatkan URL bendera yang benar secara otomatis.
     */
    public function getBenderaUrlAttribute()
    {
        if ($this->bendera) {
            if (Str::startsWith($this->bendera, 'bendera_liga/')) {
                return asset('storage/' . $this->bendera);
            }
            return asset($this->bendera);
        }
        return null;
    }

    public function klubs()
    {
        return $this->hasMany(Klub::class);
    }
}
