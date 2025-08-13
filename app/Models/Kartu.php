<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kartu extends Model
{
    use HasFactory;
    protected $fillable = ['pertandingan_id', 'pemain_id', 'jenis_kartu', 'menit_kartu'];

    public function pemain() { return $this->belongsTo(Pemain::class); }
    public function pertandingan() { return $this->belongsTo(Pertandingan::class); }
}