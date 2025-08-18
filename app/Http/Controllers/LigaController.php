<?php

namespace App\Http\Controllers;

use App\Models\Liga;
use Illuminate\Http\Request;

class LigaController extends Controller
{
    public function index()
    {
        $ligas = Liga::latest()->paginate(10);
        return view('liga.index', compact('ligas'));
    }

    public function create()
    {
        return view('liga.create');
    }

    /**
     * Menyimpan liga baru ke database.
     */
  public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ligas,nama',
            'negara' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $fileName = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('liga_logos'), $fileName);
            $logoPath = 'liga_logos/' . $fileName;
        }

        $liga = new Liga;
        $liga->nama = $request->nama;
        $liga->negara = $request->negara;
        $liga->logo = $logoPath;
        $liga->save();

        return redirect()->route('liga.index')->with('success', 'Liga berhasil ditambahkan.');
    }

    public function edit(Liga $liga)
    {
        return view('liga.edit', compact('liga'));
    }

    public function update(Request $request, Liga $liga)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ligas,nama,' . $liga->id,
            'negara' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $logoPath = $liga->logo;
        if ($request->hasFile('logo')) {
            if ($liga->logo && file_exists(public_path($liga->logo))) {
                unlink(public_path($liga->logo));
            }
            $fileName = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('liga_logos'), $fileName);
            $logoPath = 'liga_logos/' . $fileName;
        }

        // Gunakan metode save() manual
        $liga->nama = $request->nama;
        $liga->negara = $request->negara;
        $liga->logo = $logoPath;
        $liga->save();

        return redirect()->route('liga.index')->with('success', 'Liga berhasil diperbarui.');
    }

    public function destroy(Liga $liga)
    {
        // Hapus logo dari folder public jika ada
        if ($liga->logo && file_exists(public_path($liga->logo))) {
            unlink(public_path($liga->logo));
        }

        $liga->delete();
        return redirect()->route('liga.index')->with('success', 'Liga berhasil dihapus.');
    }
}