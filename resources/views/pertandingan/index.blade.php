@extends('layouts.public')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @auth
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <a href="{{ route('pertandingan.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    + Tambah Jadwal Baru
                </a>
            </div>
            @endauth

            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">JADWAL PERTANDINGAN</h3>
                    @forelse ($pertandinganAkanDatang as $tanggal => $pertandingans)
                        <div class="mb-6">
                            <p class="font-bold text-gray-700 border-b pb-2 mb-2">{{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM YYYY') }}</p>
                            @foreach ($pertandingans as $match)
                            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                                <div class="flex-1 text-right font-semibold">{{ $match->klubTuanRumah->nama }}</div>
                                <img src="{{ asset($match->klubTuanRumah->logo) }}" class="h-8 w-8 object-contain mx-4" alt="{{$match->klubTuanRumah->nama}}">
                                <div class="text-center">
                                    <div class="px-3 py-1 bg-gray-200 text-gray-800 rounded-md font-bold">{{ \Carbon\Carbon::parse($match->waktu)->format('H:i') }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $match->liga->nama }}</div>
                                </div>
                                <img src="{{ asset($match->klubTamu->logo) }}" class="h-8 w-8 object-contain mx-4" alt="{{$match->klubTamu->nama}}">
                                <div class="flex-1 font-semibold">{{ $match->klubTamu->nama }}</div>
                                @auth
                                    <a href="{{ route('pertandingan.statistik.edit', $match->id) }}" class="ml-4 text-sm text-indigo-600 flex-shrink-0">Kelola</a>
                                @endauth
                            </div>
                            @endforeach
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada jadwal pertandingan yang akan datang.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">HASIL PERTANDINGAN</h3>
                     @forelse ($pertandinganSelesai as $tanggal => $pertandingans)
                        <div class="mb-6">
                            <p class="font-bold text-gray-700 border-b pb-2 mb-2">{{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM YYYY') }}</p>
                            @foreach ($pertandingans as $match)
                            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                                <div class="flex-1 text-right font-semibold">{{ $match->klubTuanRumah->nama }}</div>
                                <img src="{{ asset($match->klubTuanRumah->logo) }}" class="h-8 w-8 object-contain mx-4" alt="{{$match->klubTuanRumah->nama}}">
                                <div class="text-center">
                                    <div class="px-3 py-1 bg-blue-800 text-white rounded-md font-bold text-lg">{{ $match->skor_tuan_rumah }} - {{ $match->skor_tamu }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $match->liga->nama }}</div>
                                </div>
                                <img src="{{ asset($match->klubTamu->logo) }}" class="h-8 w-8 object-contain mx-4" alt="{{$match->klubTamu->nama}}">
                                <div class="flex-1 font-semibold">{{ $match->klubTamu->nama }}</div>
                                <a href="{{ route('pertandingan.statistik.edit', $match->id) }}" class="ml-4 text-sm text-indigo-600 flex-shrink-0">
                                    @auth Kelola @else Detail @endauth
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada hasil pertandingan.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection