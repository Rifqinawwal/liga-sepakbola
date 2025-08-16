<?php

namespace App\Http\Controllers;

use App\Models\Klub;
use App\Models\Pemain;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return redirect('/');
        }

        // 1. Cari Klub (logika ini tetap sama)
       $klubs = Klub::where('nama', 'LIKE', "%{$query}%") // Kondisi 1: Nama klub cocok
    ->orWhereHas('pemains', function ($q) use ($query) { // Kondisi 2: Punya pemain yang namanya cocok
        $q->where('nama_pemain', 'LIKE', "%{$query}%");
    })
    ->get();

        // 2. Cari Pemain (logika ini diperbarui)
        // Cari pemain yang namanya cocok ATAU yang nama klubnya cocok
        $pemains = Pemain::with('klub')
            ->where('nama_pemain', 'LIKE', "%{$query}%") // Kondisi 1: Nama pemain cocok
            ->orWhereHas('klub', function ($q) use ($query) { // Kondisi 2: Nama klubnya cocok
                $q->where('nama', 'LIKE', "%{$query}%");
            })
            ->get();

        return view('search-results', compact('klubs', 'pemains', 'query'));
    }
}