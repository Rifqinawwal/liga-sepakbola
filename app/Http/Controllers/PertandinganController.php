<?php

namespace App\Http\Controllers;

use App\Models\Pertandingan;
use App\Models\Klub;
use Illuminate\Http\Request;
use App\Models\Liga;


class PertandinganController extends Controller
{
    public function index()
{
    $pertandinganAkanDatang = Pertandingan::with(['klubTuanRumah', 'klubTamu', 'liga'])
        ->where('tanggal_pertandingan', '>=', now()->startOfDay())
        ->whereNull('skor_tuan_rumah')
        ->orderBy('tanggal_pertandingan')->orderBy('waktu')
        ->get()
        ->groupBy('tanggal_pertandingan'); // Kelompokkan berdasarkan tanggal

    $pertandinganSelesai = Pertandingan::with(['klubTuanRumah', 'klubTamu', 'liga'])
        ->whereNotNull('skor_tuan_rumah')
        ->orderByDesc('tanggal_pertandingan')->orderByDesc('waktu')
        ->limit(30) // Ambil 30 pertandingan terakhir
        ->get()
        ->groupBy('tanggal_pertandingan'); // Kelompokkan berdasarkan tanggal

    return view('pertandingan.index', compact('pertandinganAkanDatang', 'pertandinganSelesai'));
}

    public function create()
    {
        $klubs = Klub::all();
        $ligas = Liga::all(); 
        return view('pertandingan.create', compact('klubs', 'ligas'));
    }

    public function store(Request $request)
{
    $request->validate([
        'klub_tuan_rumah_id' => 'required|exists:klubs,id',
        'klub_tamu_id' => 'required|exists:klubs,id|different:klub_tuan_rumah_id',
        'tanggal_pertandingan' => 'required|date',
        'stadion' => 'required|string|max:255', 
        'waktu' => 'required|date_format:H:i',
        'liga_id' => 'required|string|max:255',    
    ]);

    Pertandingan::create($request->all());

    return redirect()->route('pertandingan.index')->with('success', 'Jadwal pertandingan berhasil ditambahkan!');
}

    // Method show tidak kita gunakan, bisa dihapus atau dibiarkan kosong
    public function show(Pertandingan $pertandingan)
    {
        //
    }

    public function edit(Pertandingan $pertandingan)
    {
        // Halaman edit akan kita gunakan untuk input skor
        return view('pertandingan.edit', compact('pertandingan'));
    }

    public function update(Request $request, Pertandingan $pertandingan)
    {
        // Method update hanya untuk memperbarui skor
        $request->validate([
            'skor_tuan_rumah' => 'required|integer|min:0',
            'skor_tamu' => 'required|integer|min:0',
        ]);

        $pertandingan->update([
            'skor_tuan_rumah' => $request->skor_tuan_rumah,
            'skor_tamu' => $request->skor_tamu,
        ]);

        return redirect()->route('pertandingan.index')->with('success', 'Skor pertandingan berhasil diperbarui!');
    }

    public function indexByLiga(Liga $liga)
    {
        $pertandinganAkanDatang = Pertandingan::with(['klubTuanRumah', 'klubTamu', 'liga'])
            ->where('liga_id', $liga->id) // Filter berdasarkan liga
            ->where('tanggal_pertandingan', '>=', now()->startOfDay())
            ->whereNull('skor_tuan_rumah')
            ->orderBy('tanggal_pertandingan')->orderBy('waktu')
            ->get()
            ->groupBy('tanggal_pertandingan');

        $pertandinganSelesai = Pertandingan::with(['klubTuanRumah', 'klubTamu', 'liga'])
            ->where('liga_id', $liga->id) // Filter berdasarkan liga
            ->whereNotNull('skor_tuan_rumah')
            ->orderByDesc('tanggal_pertandingan')->orderByDesc('waktu')
            ->limit(30)
            ->get()
            ->groupBy('tanggal_pertandingan');

        return view('pertandingan.index', compact('pertandinganAkanDatang', 'pertandinganSelesai'));
    }


    public function destroy(Pertandingan $pertandingan)
    {
        $pertandingan->delete();
        return redirect()->route('pertandingan.index')->with('success', 'Jadwal pertandingan berhasil dihapus!');
    }
}