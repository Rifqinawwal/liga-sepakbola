<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liga extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'negara'];

    public function pertandingans()
    {
        return $this->hasMany(Pertandingan::class);
    }

    // app/Models/Liga.php
    public function klubs() // <-- Tambahkan method ini
    {
        return $this->hasMany(Klub::class);
    }
}