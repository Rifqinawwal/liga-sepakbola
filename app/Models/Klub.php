<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // <-- Ditambahkan

class Klub extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'kota',
        'stadion',
        'logo',
        'liga_id',
    ];

    /**
     * Selalu sertakan accessor ini saat data diambil.
     */
    protected $appends = ['logo_url']; // <-- Ditambahkan

    /**
     * Accessor untuk mendapatkan URL logo yang benar.
     */
    public function getLogoUrlAttribute() // <-- Ditambahkan
    {
        if ($this->logo) {
            // Cek apakah path adalah file baru dari storage
            if (Str::startsWith($this->logo, 'logo_klub/')) {
                return asset('storage/' . $this->logo);
            }
            // Jika tidak, itu adalah file lama dari public
            return asset($this->logo);
        }
        return null; // Kembalikan null jika tidak ada logo
    }

    public function pemains()
    {
        return $this->hasMany(Pemain::class);
    }

    public function liga()
    {
        return $this->belongsTo(Liga::class);
    }
}
