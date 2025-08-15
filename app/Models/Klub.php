<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

     public function pemains()
    {
        return $this->hasMany(Pemain::class);
    }

    public function liga() // <-- Tambahkan method ini
{
    return $this->belongsTo(Liga::class);
}
}