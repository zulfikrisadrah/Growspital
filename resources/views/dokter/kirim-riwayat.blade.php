{{-- @section('content')
<x-guest-layout>
    <form method="POST" action="{{ route('kirim-riwayat', ['id' => $user->id])}}">
        @method('PUT')

        @csrf
        <div class="insert text-center">
            <h1 style="color:black; font-size:30px;">Edit Medical Record</h1>
        </div>
        
        <!-- Pasien ID -->
        <div class="mt-4">
            <x-input-label for="pasien_id" :value="__('Pasien ID')" />
            <x-text-input id="pasien_id" class="block mt-1 w-full" type="text" name="pasien_id"  :value="$user->pasien->id" required autofocus autocomplete="pasien_id" readonly/>
            <x-input-error :messages="$errors->get('pasien_id')" class="mt-2" />
        </div>

        <!-- Dokter ID -->
        <div class="mt-4">
            <x-input-label for="dokter_id" :value="__('Dokter ID')" />
            <x-text-input id="dokter_id" class="block mt-1 w-full" type="text" name="dokter_id" :value="auth()->user()->id" required autofocus autocomplete="dokter_id" readonly/>
            <x-input-error :messages="$errors->get('dokter_id')" class="mt-2" />
        </div>

        <!-- Keluhan -->
        <div class="mt-4">
            <x-input-label for="keluhan" :value="__('Keluhan')" />
            <x-text-input id="keluhan" class="block mt-1 w-full" type="text" name="keluhan"  required autocomplete="keluhan" />
            <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
        </div>   

        <!-- Kategori -->
        <div class="mt-4">
            <x-input-label for="kategori" :value="__('Kategori')"/>
            <div class="kategori" style="display:flex;">
                <div class="choice" style="margin-right: 50px">
                    <input type="radio" name="kategori" value="umum"  required>
                    <label for="umum">Umum</label>
                </div>
                <div class="choice">
                    <input type="radio" name="kategori" value="gigi" required>
                    <label for="gigi">Gigi</label>
                </div>
            </div>
        </div>

        <!-- Tindakan -->
        <div class="mt-4">
            <x-input-label for="tindakan" :value="__('Tindakan')" />
            <x-text-input id="tindakan" class="block mt-1 w-full" type="text" name="tindakan" :value="old('tindakan')" required autofocus autocomplete="tindakan" />
            <x-input-error :messages="$errors->get('tindakan')" class="mt-2" />
        </div>

        <!-- Obat ID -->
        <div class="mt-4">
            <x-input-label for="obat_id" :value="__('Obat ID')" />
            <x-text-input id="obat_id" class="block mt-1 w-full" type="text" name="obat_id" :value="old('obat_id')" required autofocus autocomplete="obat_id" />
            <x-input-error :messages="$errors->get('obat_id')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="/pasien-list">
                {{ __('Kembali') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Tambahkan') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
