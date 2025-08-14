<?php

namespace App\Http\Controllers;

use App\Models\Klub;
use App\Models\Pertandingan;
use Illuminate\Http\Request;
use App\Models\Liga;

class KlasemenController extends Controller
{
    public function index(Request $request)
    {
        $ligas = Liga::all();
        $selectedLigaId = $request->input('liga_id'); // Menggunakan nama variabel yang lebih jelas

        $klubs = Klub::all();

        $pertandingansQuery = Pertandingan::whereNotNull('skor_tuan_rumah');

        // PERBAIKAN ADA DI SINI: Menggunakan 'liga_id'
        if ($selectedLigaId) {
            $pertandingansQuery->where('liga_id', $selectedLigaId);
        }

        $pertandingans = $pertandingansQuery->get();

        $klasemen = [];

        foreach ($klubs as $klub) {
            $main = 0;
            $menang = 0;
            $seri = 0;
            $kalah = 0;
            $gol_masuk = 0;
            $gol_kalah = 0;

            $pertandinganKlub = $pertandingans->filter(function ($p) use ($klub) {
                return $p->klub_tuan_rumah_id == $klub->id || $p->klub_tamu_id == $klub->id;
            });

            foreach ($pertandinganKlub as $p) {
                $main++;
                if ($p->klub_tuan_rumah_id == $klub->id) {
                    $gol_masuk += $p->skor_tuan_rumah;
                    $gol_kalah += $p->skor_tamu;
                    if ($p->skor_tuan_rumah > $p->skor_tamu) $menang++;
                    elseif ($p->skor_tuan_rumah == $p->skor_tamu) $seri++;
                    else $kalah++;
                } else {
                    $gol_masuk += $p->skor_tamu;
                    $gol_kalah += $p->skor_tuan_rumah;
                    if ($p->skor_tamu > $p->skor_tuan_rumah) $menang++;
                    elseif ($p->skor_tamu == $p->skor_tuan_rumah) $seri++;
                    else $kalah++;
                }
            }

            if ($main > 0) {
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
        }

        $klasemenCollection = collect($klasemen)->sortBy([
            ['poin', 'desc'],
            ['selisih_gol', 'desc'],
        ]);

        return view('klasemen.index', [
            'klasemen' => $klasemenCollection,
            'ligas' => $ligas,
            'selectedLigaId' => $selectedLigaId // Mengirim variabel dengan nama yang konsisten
        ]);
    }
}