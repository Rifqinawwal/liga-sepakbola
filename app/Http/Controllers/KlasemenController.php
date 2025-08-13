<?php

namespace App\Http\Controllers;

use App\Models\Klub;
use App\Models\Pertandingan;
use Illuminate\Http\Request;

class KlasemenController extends Controller
{
    public function index()
    {
        // 1. Ambil semua klub dan pertandingan yang sudah ada skornya
        $klubs = Klub::all();
        $pertandingans = Pertandingan::whereNotNull('skor_tuan_rumah')->get();

        $klasemen = [];

        // 2. Loop setiap klub untuk menghitung statistik
        foreach ($klubs as $klub) {
            $main = 0;
            $menang = 0;
            $seri = 0;
            $kalah = 0;
            $gol_masuk = 0;
            $gol_kalah = 0;

            // Filter pertandingan yang hanya melibatkan klub ini
            $pertandinganKlub = $pertandingans->filter(function ($p) use ($klub) {
                return $p->klub_tuan_rumah_id == $klub->id || $p->klub_tamu_id == $klub->id;
            });

            foreach ($pertandinganKlub as $p) {
                $main++;

                if ($p->klub_tuan_rumah_id == $klub->id) { // Jika klub ini adalah tuan rumah
                    $gol_masuk += $p->skor_tuan_rumah;
                    $gol_kalah += $p->skor_tamu;

                    if ($p->skor_tuan_rumah > $p->skor_tamu) {
                        $menang++;
                    } elseif ($p->skor_tuan_rumah == $p->skor_tamu) {
                        $seri++;
                    } else {
                        $kalah++;
                    }
                } else { // Jika klub ini adalah tim tamu
                    $gol_masuk += $p->skor_tamu;
                    $gol_kalah += $p->skor_tuan_rumah;

                    if ($p->skor_tamu > $p->skor_tuan_rumah) {
                        $menang++;
                    } elseif ($p->skor_tamu == $p->skor_tuan_rumah) {
                        $seri++;
                    } else {
                        $kalah++;
                    }
                }
            }

            // 3. Simpan hasil perhitungan ke dalam array
            $klasemen[] = [
                'klub_id' => $klub->id,
                'nama_klub' => $klub->nama,
                'logo_klub' => $klub->logo,
                'main' => $main,
                'menang' => $menang,
                'seri' => $seri,
                'kalah' => $kalah,
                'gol_masuk' => $gol_masuk,
                'gol_kalah' => $gol_kalah,
                'selisih_gol' => $gol_masuk - $gol_kalah,
                'poin' => ($menang * 3) + ($seri * 1),
            ];
        }

        // 4. Urutkan klasemen berdasarkan Poin (tertinggi), lalu Selisih Gol (tertinggi)
        $klasemenCollection = collect($klasemen)->sortBy([
            ['poin', 'desc'],
            ['selisih_gol', 'desc'],
        ]);

        return view('klasemen.index', ['klasemen' => $klasemenCollection]);
    }
}