<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gol extends Model
{
    use HasFactory;
    protected $fillable = ['pertandingan_id', 'pemain_id', 'assist_pemain_id', 'menit_gol'];

    public function pemain() { return $this->belongsTo(Pemain::class); }
    public function assistPemain() { return $this->belongsTo(Pemain::class, 'assist_pemain_id'); }
    public function pertandingan() { return $this->belongsTo(Pertandingan::class); }
}