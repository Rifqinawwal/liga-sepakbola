<?php

namespace App\Http\Controllers;

use App\Models\Liga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LigaController extends Controller
{
    // ... (method index tetap sama) ...
    public function index()
    {
        $ligas = Liga::latest()->paginate(10);
        return view('liga.index', compact('ligas'));
    }


    // ===== FUNGSI YANG HILANG & SAYA TAMBAHKAN =====
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('liga.create');
    }
    // ===== AKHIR BAGIAN PERBAIKAN =====


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'negara' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'bendera' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logo_liga', 'public');
        }

        $benderaPath = null;
        if ($request->hasFile('bendera')) {
            $benderaPath = $request->file('bendera')->store('bendera_liga', 'public');
        }

        Liga::create([
            'nama' => $request->nama,
            'negara' => $request->negara,
            'logo' => $logoPath,
            'bendera' => $benderaPath,
        ]);

        return redirect()->route('liga.index')->with('success', 'Liga berhasil ditambahkan.');
    }

    // ... (method show, edit tetap sama) ...
    public function edit(Liga $liga)
    {
        return view('liga.edit', compact('liga'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Liga $liga)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'negara' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'bendera' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $logoPath = $liga->logo;
        if ($request->hasFile('logo')) {
            if ($liga->logo) {
                Storage::disk('public')->delete($liga->logo);
            }
            $logoPath = $request->file('logo')->store('logo_liga', 'public');
        }

        $benderaPath = $liga->bendera;
        if ($request->hasFile('bendera')) {
            if ($liga->bendera) {
                Storage::disk('public')->delete($liga->bendera);
            }
            $benderaPath = $request->file('bendera')->store('bendera_liga', 'public');
        }

        $liga->update([
            'nama' => $request->nama,
            'negara' => $request->negara,
            'logo' => $logoPath,
            'bendera' => $benderaPath,
        ]);

        return redirect()->route('liga.index')->with('success', 'Liga berhasil diperbarui.');
    }

    // ... (method destroy tetap sama) ...
    public function destroy(Liga $liga)
    {
        if ($liga->logo) {
            Storage::disk('public')->delete($liga->logo);
        }
        if ($liga->bendera) {
            Storage::disk('public')->delete($liga->bendera);
        }
        $liga->delete();
        return redirect()->route('liga.index')->with('success', 'Liga berhasil dihapus.');
    }
}
