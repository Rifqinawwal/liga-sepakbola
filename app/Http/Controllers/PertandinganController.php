<?php

namespace App\Http\Controllers;

use App\Models\Pertandingan;
use App\Models\Klub;
use Illuminate\Http\Request;

class PertandinganController extends Controller
{
    public function index()
{
    // Mengambil pertandingan yang akan datang (tanggalnya hari ini atau di masa depan DAN skornya masih kosong)
    $pertandinganAkanDatang = Pertandingan::with(['klubTuanRumah', 'klubTamu'])
        ->where('tanggal_pertandingan', '>=', now()->startOfDay())
        ->whereNull('skor_tuan_rumah')
        ->latest('tanggal_pertandingan')
        ->paginate(10, ['*'], 'akan_datang'); // Paginasi terpisah

    // Mengambil pertandingan yang sudah selesai (tanggalnya sudah lewat ATAU skornya sudah terisi)
    $pertandinganSelesai = Pertandingan::with(['klubTuanRumah', 'klubTamu'])
        ->where(function ($query) {
            $query->where('tanggal_pertandingan', '<', now()->startOfDay())
                  ->orWhereNotNull('skor_tuan_rumah');
        })
        ->latest('tanggal_pertandingan')
        ->paginate(10, ['*'], 'selesai'); // Paginasi terpisah

    return view('pertandingan.index', compact('pertandinganAkanDatang', 'pertandinganSelesai'));
}

    public function create()
    {
        $klubs = Klub::all();
        return view('pertandingan.create', compact('klubs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'klub_tuan_rumah_id' => 'required|exists:klubs,id',
            'klub_tamu_id' => 'required|exists:klubs,id|different:klub_tuan_rumah_id',
            'tanggal_pertandingan' => 'required|date',
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

    public function destroy(Pertandingan $pertandingan)
    {
        $pertandingan->delete();
        return redirect()->route('pertandingan.index')->with('success', 'Jadwal pertandingan berhasil dihapus!');
    }
}