<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Umur -->
        <div class="mt-4">
            <x-input-label for="umur" :value="__('Umur')" />
            <x-text-input id="umur" class="block mt-1 w-full" type="number" min="0" name="umur" :value="old('umur')" required autofocus autocomplete="umur" />
            <x-input-error :messages="$errors->get('umur')" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="mt-4"> 
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Roles -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Roles')"/>
            <div class="roles" style="display:flex; justify-content:space-between">
                <div class="choice">
                    <input type="radio" name="role" value="dokter" {{ old('role') == 'dokter' ? 'checked' : '' }} required>
                    <label for="dokter">Dokter</label>
                </div>
                <div class="choice">
                    <input type="radio" name="role" value="apoteker" {{ old('role') == 'apoteker' ? 'checked' : '' }} required>
                    <label for="apoteker">Apoteker</label>
                </div>
                <div class="choice">
                    <input type="radio" name="role" value="pasien" {{ old('role') == 'pasien' ? 'checked' : '' }} required>
                    <label for="pasien">Pasien</label>
                </div>
            </div>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
