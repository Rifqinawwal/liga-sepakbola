<?php

namespace App\Http\Controllers;

use App\Models\Klub;
use App\Models\Pemain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return redirect('/');
        }

        // --- Pencarian di Database Lokal (Klub & Pemain) ---
        $klubs = Klub::where('nama', 'LIKE', "%{$query}%")
            ->orWhereHas('liga', function ($q) use ($query) {
                $q->where('nama', 'LIKE', "%{$query}%");
            })
            ->get();

        $pemains = Pemain::with('klub')
            ->where('nama_pemain', 'LIKE', "%{$query}%")
            ->orWhereHas('klub', function ($q) use ($query) {
                $q->where('nama', 'LIKE', "%{$query}%");
            })
            ->get();

        // --- Pencarian Berita dari NewsAPI ---
        $articles = [];
        $apiKey = env('NEWS_API_KEY');

        if ($apiKey) {
            $response = Http::get('https://newsapi.org/v2/everything', [
                'q' => $query, // Gunakan kata kunci dari pengguna
                'language' => 'id',
                'sortBy' => 'relevancy',
                'apiKey' => $apiKey,
                'pageSize' => 3 // Ambil 3 berita paling relevan
            ]);

            if ($response->successful() && $response->json()['totalResults'] > 0) {
                $articles = $response->json()['articles'];
            }
        }

        return view('search-results', compact('klubs', 'pemains', 'articles', 'query'));
    }
}