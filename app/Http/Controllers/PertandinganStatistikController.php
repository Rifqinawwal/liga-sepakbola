<?php

namespace App\Http\Controllers;

use App\Models\Gol;
use App\Models\Klub;
use App\Models\Kartu;
use App\Models\Pemain;
use App\Models\Pertandingan;
use Illuminate\Http\Request;

class PertandinganStatistikController extends Controller
{
    /**
     * Menampilkan halaman untuk mengelola skor dan statistik pertandingan.
     */
    public function edit(Pertandingan $pertandingan)
    {
        // Ambil semua pemain dari kedua klub yang bertanding
        $pemains = Pemain::where('klub_id', $pertandingan->klub_tuan_rumah_id)
                         ->orWhere('klub_id', $pertandingan->klub_tamu_id)
                         ->orderBy('nama_pemain')
                         ->get();

        // Ambil data statistik yang sudah ada
        $gols = $pertandingan->gols()->with(['pemain', 'assistPemain'])->get();

        $kartus = $pertandingan->kartus()->with('pemain')->get();

        return view('pertandingan.statistik', compact('pertandingan', 'pemains', 'gols', 'kartus'));
    }

    /**
     * Update skor utama pertandingan.
     */
    public function updateSkor(Request $request, Pertandingan $pertandingan)
    {
        $request->validate([
            'skor_tuan_rumah' => 'required|integer|min:0',
            'skor_tamu' => 'required|integer|min:0',
        ]);

        $pertandingan->update($request->only(['skor_tuan_rumah', 'skor_tamu']));

        return back()->with('success', 'Skor berhasil diperbarui!');
    }

    /**
     * Menyimpan data gol baru.
     */
    public function storeGol(Request $request, Pertandingan $pertandingan)
    {
        $request->validate([
            'pemain_id' => 'required|exists:pemains,id',
            'assist_pemain_id' => 'nullable|exists:pemains,id|different:pemain_id',
            'menit_gol' => 'required|integer|min:1',
        ]);

        $pertandingan->gols()->create($request->all());

        return back()->with('success', 'Data gol berhasil ditambahkan!');
    }

    /**
     * Menghapus data gol.
     */
    public function destroyGol(Gol $gol)
    {
        $gol->delete();
        return back()->with('success', 'Data gol berhasil dihapus.');
    }

    // app/Http/Controllers/PertandinganStatistikController.php

// ... (method destroyGol yang sudah ada) ...

/**
 * Menyimpan data kartu baru.
 */
public function storeKartu(Request $request, Pertandingan $pertandingan)
{
    $request->validate([
        'pemain_id' => 'required|exists:pemains,id',
        'jenis_kartu' => 'required|in:kuning,merah',
        'menit_kartu' => 'required|integer|min:1',
    ]);

    $pertandingan->kartus()->create($request->all());

    return back()->with('success', 'Data kartu berhasil ditambahkan!');
}

/**
 * Menghapus data kartu.
 */
public function destroyKartu(Kartu $kartu)
{
    $kartu->delete();
    return back()->with('success', 'Data kartu berhasil dihapus.');
}
}