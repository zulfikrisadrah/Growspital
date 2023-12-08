<x-guest-layout>
    <form method="POST" action="{{ route('update-pasien', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="insert text-center">
            <h1 style="color:black; font-size:30px;">Informasi Tambahan User</h1>
        </div>
        <!-- Keluhan -->
        <div class="mt-4">
            <x-input-label for="keluhan" :value="__('Keluhan')" />
            <x-text-input id="keluhan" class="block mt-1 w-full" type="text" name="keluhan" required autocomplete="keluhan" />
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
                    <input type="radio" name="kategori" value="gigi"  required>
                    <label for="gigi">Gigi</label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="/user-list">
                {{ __('Kembali') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Update') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
