<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemain extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'klub_id',
        'nama_pemain',
        'posisi',
        'nomor_punggung',
        'foto', // Kita tambahkan kolom foto
    ];

    /**
     * Mendapatkan klub dari pemain.
     */
    public function klub()
    {
        return $this->belongsTo(Klub::class);
    }

    // ... di dalam kelas Pemain ...
    public function gols() { return $this->hasMany(Gol::class); }
    public function kartus() { return $this->hasMany(Kartu::class); }
}