<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Liga') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif
                    <form action="{{ route('liga.update', $liga->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div>
                            <x-input-label for="nama" value="Nama Liga" />
                            <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama', $liga->nama)" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="negara" value="Negara" />
                            <x-text-input id="negara" class="block mt-1 w-full" type="text" name="negara" :value="old('negara', $liga->negara)" required />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('liga.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>