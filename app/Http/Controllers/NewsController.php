<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    public function index()
    {
        $cacheKey = 'berita_sepak_bola_terbaru_id_v2'; // Kunci cache baru

        $articles = Cache::remember($cacheKey, now()->addHours(12), function () {
            
            $apiKey = env('NEWS_API_KEY');
            if (!$apiKey) return [];

            $response = Http::get('https://newsapi.org/v2/everything', [
                // Sumber berita yang lebih fokus ke sepak bola
                'sources' => 'four-four-two,talksport,the-sport-bible',
                'language' => 'en', // Ambil dalam bahasa Inggris
                'sortBy' => 'publishedAt',
                'apiKey' => $apiKey,
                'pageSize' => 6
            ]);

            if ($response->successful() && !empty($response->json()['articles'])) {
                $articles = $response->json()['articles'];

                // Proses terjemahan untuk setiap artikel
                foreach ($articles as &$article) {
                    // Cek jika judul tidak kosong sebelum menerjemahkan
                    if (!empty($article['title'])) {
                        $translationResponse = Http::get('https://api.mymemory.translated.net/get', [
                            'q' => $article['title'],
                            'langpair' => 'en|id',
                        ]);

                        if($translationResponse->successful() && $translationResponse->json()['responseStatus'] == 200) {
                            $article['title'] = $translationResponse->json()['responseData']['translatedText'];
                        }
                    }
                }
                return $articles;
            }

            return [];
        });
        
        return view('welcome', compact('articles'));
    }
}