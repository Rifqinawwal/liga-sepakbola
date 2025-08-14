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

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ligas,nama',
            'negara' => 'required|string|max:255',
        ]);

        Liga::create($request->all());
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
        ]);

        $liga->update($request->all());
        return redirect()->route('liga.index')->with('success', 'Liga berhasil diperbarui.');
    }

    public function destroy(Liga $liga)
    {
        $liga->delete();
        return redirect()->route('liga.index')->with('success', 'Liga berhasil dihapus.');
    }
}