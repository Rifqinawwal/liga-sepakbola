<?php

namespace App\Http\Controllers;

use App\Models\Klub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Liga;

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
    $ligas = Liga::all(); // Ambil semua data liga
    return view('klub.create', compact('ligas'));
}

    /**
     * Menyimpan klub baru ke database.
     */
    public function store(Request $request)
{
    // 1. Validasi Input (sudah benar)
    $request->validate([
        'nama' => 'required|string|max:255|unique:klubs,nama',
        'kota' => 'required|string|max:255',
        'stadion' => 'required|string|max:255',
        'liga_id' => 'required|exists:ligas,id',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $logoPath = null;
    if ($request->hasFile('logo')) {
        $fileName = time() . '.' . $request->logo->extension();
        $request->logo->move(public_path('logos'), $fileName);
        $logoPath = 'logos/' . $fileName;
    }

    // 2. Buat Klub Baru (BAGIAN YANG DIPERBAIKI)
    // Pastikan 'liga_id' disertakan di sini
    Klub::create([
        'nama' => $request->nama,
        'kota' => $request->kota,
        'stadion' => $request->stadion,
        'liga_id' => $request->liga_id, // <-- Baris ini yang paling penting
        'logo' => $logoPath,
    ]);

    return redirect()->route('klub.index')->with('success', 'Klub berhasil ditambahkan!');
}

    /**
     * Menampilkan form untuk mengedit klub.
     */
    public function edit(Klub $klub)
{
    $ligas = Liga::all(); // Ambil semua data liga
    return view('klub.edit', compact('klub', 'ligas'));
}

    /**
     * Memperbarui data klub di database.
     */
    public function update(Request $request, Klub $klub)
    {
        // 1. Validasi Input (Bagian ini sudah benar)
        $request->validate([
            'nama' => 'required|string|max:255|unique:klubs,nama,' . $klub->id,
            'kota' => 'required|string|max:255',
            'stadion' => 'required|string|max:255',
            'liga_id' => 'required|exists:ligas,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $logoPath = $klub->logo;
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($klub->logo && file_exists(public_path($klub->logo))) {
                unlink(public_path($klub->logo));
            }

            // Upload logo baru
            $fileName = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('logos'), $fileName);
            $logoPath = 'logos/' . $fileName;
        }
        
        // 2. Update data klub (BAGIAN PENTING)
        // Perintah ini mengambil SEMUA data yang lolos validasi dan menyimpannya.
        $klub->update([
            'nama' => $request->nama,
            'kota' => $request->kota,
            'stadion' => $request->stadion,
            'liga_id' => $request->liga_id, // <-- Memastikan liga_id ikut disimpan
            'logo' => $logoPath,
        ]);

        return redirect()->route('klub.index')->with('success', 'Data klub berhasil diperbarui!');
    }

    /**
     * Menghapus klub dari database.
     */
    // Kode Baru yang Lebih Konsisten
    public function destroy(Klub $klub)
    {
        // Hapus logo dari folder public
        if ($klub->logo && file_exists(public_path($klub->logo))) {
            unlink(public_path($klub->logo));
        }

        $klub->delete();

        return redirect()->route('klub.index')->with('success', 'Klub berhasil dihapus!');
    }
}