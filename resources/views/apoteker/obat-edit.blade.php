<x-guest-layout>
    <form method="POST" action="/obat-update/{{$obat->id}}">
        @csrf

        <div class="insert text-center">
            <h1 style="color:black; font-size:30px;">Edit Obat</h1>
        </div>

        <!-- Nama obat -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Nama obat')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$obat->name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Deskripsi -->
        <div class="mt-4">
            <x-input-label for="deskripsi" :value="__('Deskripsi')" />
            <x-text-input id="deskripsi" class="block mt-1 w-full" type="text" name="deskripsi" :value="$obat->deskripsi" required autofocus autocomplete="deskripsi" />
            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
        </div>

        <!-- Tipe -->
        <div class="mt-4">
            <x-input-label for="tipe" :value="__('Tipe obat')"/>
            <div class="tipe flex">
                <div class="choice" style="margin-right:50px">
                    <input type="radio" name="tipe" value="keras" {{ old('tipe', $obat->tipe) == 'keras' ? 'checked' : '' }} required>
                    <label for="keras">Keras</label>
                </div>
                <div class="choice">
                    <input type="radio" name="tipe" value="biasa" {{ old('tipe', $obat->tipe) == 'biasa' ? 'checked' : '' }} required>
                    <label for="biasa">Biasa</label>
                </div>
            </div>
        </div>        

        <!-- Stok-->
        <div class="mt-4">
            <x-input-label for="stok" :value="__('Stok')" />
            <x-text-input id="stok" class="block mt-1 w-full" type="number" min="0" name="stok" :value="$obat->stok" required autocomplete="stok" />
            <x-input-error :messages="$errors->get('stok')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('obat-list') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Kembali') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Update') }}
            </x-primary-button>
        </div>
    </form> 
</x-guest-layout>
