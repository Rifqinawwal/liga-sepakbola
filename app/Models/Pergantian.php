<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pergantian extends Model
{
    use HasFactory;
    protected $fillable = ['pertandingan_id', 'pemain_masuk_id', 'pemain_keluar_id', 'menit_pergantian'];

    public function pemainMasuk() { return $this->belongsTo(Pemain::class, 'pemain_masuk_id'); }
    public function pemainKeluar() { return $this->belongsTo(Pemain::class, 'pemain_keluar_id'); }
    public function pertandingan() { return $this->belongsTo(Pertandingan::class); }
}