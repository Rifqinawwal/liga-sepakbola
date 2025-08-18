<?php

namespace App\Http\Controllers;

use App\Models\Pemain;
use App\Models\Klub; // <-- Jangan lupa import model Klub
use Illuminate\Http\Request;
use App\Models\Liga;

class PemainController extends Controller
{
    public function index()
    {
        // Mengambil semua pemain dengan data klub terkait
        $pemains = Pemain::with('klub')->latest()->paginate(10);
        return view('pemain.index', compact('pemains'));
    }

    public function create()
    {
        // Mengambil semua klub untuk ditampilkan di dropdown
        $klubs = Klub::all();
        return view('pemain.create', compact('klubs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'klub_id' => 'required|exists:klubs,id',
            'nama_pemain' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'nomor_punggung' => 'required|integer|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fileName = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('pemain_fotos'), $fileName);
            $fotoPath = 'pemain_fotos/' . $fileName;
        }

        Pemain::create([
            'klub_id' => $request->klub_id,
            'nama_pemain' => $request->nama_pemain,
            'posisi' => $request->posisi,
            'nomor_punggung' => $request->nomor_punggung,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('pemain.index')->with('success', 'Pemain berhasil ditambahkan!');
    }

    public function edit(Pemain $pemain)
    {
        $klubs = Klub::all(); // Data klub untuk dropdown
        $ligas = Liga::all();
        return view('pemain.edit', compact('pemain', 'klubs', 'ligas'));
    }

    public function update(Request $request, Pemain $pemain)
    {
        $request->validate([
            'klub_id' => 'required|exists:klubs,id',
            'nama_pemain' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'nomor_punggung' => 'required|integer|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $fotoPath = $pemain->foto;
        if ($request->hasFile('foto')) {
            if ($pemain->foto && file_exists(public_path($pemain->foto))) {
                unlink(public_path($pemain->foto));
            }
            $fileName = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('pemain_fotos'), $fileName);
            $fotoPath = 'pemain_fotos/' . $fileName;
        }

        $pemain->update([
            'klub_id' => $request->klub_id,
            'nama_pemain' => $request->nama_pemain,
            'posisi' => $request->posisi,
            'nomor_punggung' => $request->nomor_punggung,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('pemain.index')->with('success', 'Data pemain berhasil diperbarui!');
    }

    public function indexByKlub(Klub $klub)
    {
        $pemains = $klub->pemains()->with('klub')->latest()->paginate(10);
        return view('pemain.index', compact('pemains'));
    }

    public function destroy(Pemain $pemain)
    {
        if ($pemain->foto && file_exists(public_path($pemain->foto))) {
            unlink(public_path($pemain->foto));
        }
        $pemain->delete();
        return redirect()->route('pemain.index')->with('success', 'Pemain berhasil dihapus!');
    }
}