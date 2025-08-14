<?php

namespace App\Http\Controllers;

use App\Models\Gol;
use App\Models\Kartu;
use App\Models\Pemain;
use App\Models\Pertandingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PertandinganStatistikController extends Controller
{
    public function edit(Pertandingan $pertandingan)
    {
        $pemains = Pemain::where('klub_id', $pertandingan->klub_tuan_rumah_id)
                         ->orWhere('klub_id', $pertandingan->klub_tamu_id)
                         ->orderBy('nama_pemain')
                         ->get();

        $pertandingan->load(['gols.pemain', 'gols.assistPemain', 'kartus.pemain']);

        return view('pertandingan.statistik', compact('pertandingan', 'pemains'));
    }

    public function update(Request $request, Pertandingan $pertandingan)
    {
        $validated = $request->validate([
            'skor_tuan_rumah' => 'required|integer|min:0',
            'skor_tamu' => 'required|integer|min:0',
            'gols' => 'nullable|array',
            'gols.*.pemain_id' => 'required|exists:pemains,id',
            'gols.*.assist_pemain_id' => 'nullable|exists:pemains,id|different:gols.*.pemain_id',
            'gols.*.menit_gol' => 'required|integer|min:1',
            'kartus' => 'nullable|array',
            'kartus.*.pemain_id' => 'required|exists:pemains,id',
            'kartus.*.jenis_kartu' => 'required|in:kuning,merah',
            'kartus.*.menit_kartu' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($validated, $pertandingan) {
                // 1. Update Skor Utama
                $pertandingan->update([
                    'skor_tuan_rumah' => $validated['skor_tuan_rumah'],
                    'skor_tamu' => $validated['skor_tamu'],
                ]);

                // 2. Hapus semua statistik lama
                $pertandingan->gols()->delete();
                $pertandingan->kartus()->delete();

                // 3. Masukkan kembali data gol dari form
                if (!empty($validated['gols'])) {
                    foreach ($validated['gols'] as $golData) {
                        $pertandingan->gols()->create($golData);
                    }
                }

                // 4. Masukkan kembali data kartu dari form
                if (!empty($validated['kartus'])) {
                    foreach ($validated['kartus'] as $kartuData) {
                        $pertandingan->kartus()->create($kartuData);
                    }
                }
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }

        return redirect()->route('pertandingan.index')->with('success', 'Statistik pertandingan berhasil disimpan!');
    }
}