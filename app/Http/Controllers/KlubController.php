<?php

namespace App\Http\Controllers;

use App\Models\Klub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KlubController extends Controller
{
    /**
     * Menampilkan daftar semua klub.
     */
    public function index()
    {
        $klubs = Klub::latest()->paginate(10); // Ambil semua klub, urutkan dari terbaru
        return view('klub.index', compact('klubs'));
    }

    /**
     * Menampilkan form untuk membuat klub baru.
     */
    public function create()
    {
        return view('klub.create');
    }

    /**
     * Menyimpan klub baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama' => 'required|string|max:255|unique:klubs,nama',
            'kota' => 'required|string|max:255',
            'stadion' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            // 2. Upload Logo
            // Kode Baru
            $fileName = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('logos'), $fileName);
            $logoPath = 'logos/' . $fileName;
        }

        // 3. Buat Klub Baru
        Klub::create([
            'nama' => $request->nama,
            'kota' => $request->kota,
            'stadion' => $request->stadion,
            'logo' => $logoPath,
        ]);

        return redirect()->route('klub.index')->with('success', 'Klub berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit klub.
     */
    public function edit(Klub $klub)
    {
        return view('klub.edit', compact('klub'));
    }

    /**
     * Memperbarui data klub di database.
     */
    public function update(Request $request, Klub $klub)
    {
        // 1. Validasi Input
        $request->validate([
            'nama' => 'required|string|max:255|unique:klubs,nama,' . $klub->id,
            'kota' => 'required|string|max:255',
            'stadion' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Kode Baru untuk method update
        $logoPath = $klub->logo;
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada (opsional, tapi bagus)
            if ($klub->logo && file_exists(public_path($klub->logo))) {
                unlink(public_path($klub->logo));
            }

            // Upload logo baru
            $fileName = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('logos'), $fileName);
            $logoPath = 'logos/' . $fileName;
        }
        // 4. Update data klub
        $klub->update([
            'nama' => $request->nama,
            'kota' => $request->kota,
            'stadion' => $request->stadion,
            'logo' => $logoPath,
        ]);

        return redirect()->route('klub.index')->with('success', 'Data klub berhasil diperbarui!');
    }

    /**
     * Menghapus klub dari database.
     */
    public function destroy(Klub $klub)
    {
        // 1. Hapus logo dari penyimpanan
        if ($klub->logo) {
            Storage::delete($klub->logo);
        }

        // 2. Hapus data dari database
        $klub->delete();

        return redirect()->route('klub.index')->with('success', 'Klub berhasil dihapus!');
    }
}