<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertandingan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    'klub_tuan_rumah_id',
    'klub_tamu_id',
    'tanggal_pertandingan',
    'stadion', 
    'waktu',
    'liga_id',   
    'skor_tuan_rumah',
    'skor_tamu',
];

    /**
     * Mendapatkan data klub tuan rumah.
     */
    public function klubTuanRumah()
    {
        return $this->belongsTo(Klub::class, 'klub_tuan_rumah_id');
    }

    // ... di dalam kelas Pertandingan ...
    public function gols() { return $this->hasMany(Gol::class); }
    public function kartus() { return $this->hasMany(Kartu::class); }
    public function pergantians() { return $this->hasMany(Pergantian::class); }
    public function liga() // <-- Tambahkan relasi ini
{
    return $this->belongsTo(Liga::class);
}

    /**
     * Mendapatkan data klub tamu.
     */
    public function klubTamu()
    {
        return $this->belongsTo(Klub::class, 'klub_tamu_id');
    }
}