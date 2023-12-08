<x-guest-layout>
    <form method="POST" action="/user-update/{{$user->id}}">
        @csrf

        <div class="insert text-center">
            <h1 style="color:black; font-size:30px;">Edit User</h1>
        </div>
        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$user->name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Umur -->
        <div class="mt-4">
            <x-input-label for="umur" :value="__('Umur')" />
            <x-text-input id="umur" class="block mt-1 w-full" type="number" min="0" name="umur" :value="$user->umur" required autofocus autocomplete="umur" />
            <x-input-error :messages="$errors->get('umur')" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="mt-4"> 
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="$user->username" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Roles -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Roles')"/>
            <div class="roles" style="display:flex; justify-content:space-between">
                <div class="choice">
                    <input type="radio" name="role" value="dokter" {{ $user->role == 'dokter' ? 'checked' : '' }} required>
                    <label for="dokter">Dokter</label>
                </div>
                <div class="choice">
                    <input type="radio" name="role" value="apoteker" {{ $user->role == 'apoteker' ? 'checked' : '' }} required>
                    <label for="apoteker">Apoteker</label>
                </div>
                <div class="choice">
                    <input type="radio" name="role" value="pasien" {{ $user->role == 'pasien' ? 'checked' : '' }} required>
                    <label for="pasien">Pasien</label>
                </div>
            </div>
        </div>
        
        {{-- <!-- Keluhan -->
        @if ($user->role == 'pasien')
        <div class="mt-4">
            <x-input-label for="keluhan" :value="__('Keluhan')" />
            <x-text-input id="keluhan" class="block mt-1 w-full" type="text" name="keluhan" :value="$user->pasien->keluhan" required autocomplete="keluhan" />
            <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
        </div>   

        <!-- Roles -->
        <div class="mt-4">
            <x-input-label for="kategori" :value="__('Kategori')"/>
            <div class="kategori" style="display:flex;">
                <div class="choice" style="margin-right: 50px">
                    <input type="radio" name="kategori" value="umum" {{ $user->pasien->kategori == 'umum' ? 'checked' : '' }} required>
                    <label for="umum">Umum</label>
                </div>
                <div class="choice">
                    <input type="radio" name="kategori" value="gigi" {{ $user->pasien->kategori == 'gigi' ? 'checked' : '' }} required>
                    <label for="gigi">Gigi</label>
                </div>
            </div>
        </div>        
        @endif --}}

        <!-- Status -->
        @if ($user->role == 'dokter')
        <div class="mt-4">
            <x-input-label for="status" :value="__('Status')"/>
            <div class="status" style="display:flex;">
                <div class="choice" style="margin-right: 50px">
                    <input type="radio" name="status" value="bertugas" {{ $user->dokter->status == 'bertugas' ? 'checked' : '' }} required>
                    <label for="bertugas">Bertugas</label>
                </div>
                <div class="choice">
                    <input type="radio" name="status" value="tidak bertugas" {{ $user->dokter->status == 'tidak bertugas' ? 'checked' : '' }} required>
                    <label for="tidak bertugas">Tidak Bertugas</label>
                </div>
            </div>
        </div>        
        @endif

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$user->email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            :value="$user->password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            :value="$user->password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
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
