<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Apoteker;
use App\Models\Pasien;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'umur' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'role' => ['required', Rule::in(['dokter', 'apoteker', 'pasien'])],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $role = $request->input('role');

        $user = User::create([
            'name' => $request->name,
            'umur' => $request->umur,
            'username' => $request->username,
            'role' => $role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($role);

        if ($role === 'dokter') {
            $dokterData = [
                'user_id' => $user->id,
                'spesialis' => $request->input('spesialis', 'umum'), 
                'status' => $request->input('status', 'Tidak Bertugas'),     
            ];
    
            Dokter::create($dokterData);
        }

        if ($role === 'apoteker') {
            $apotekerData = [
                'user_id' => $user->id,
            ];
    
            Apoteker::create($apotekerData);
        }

        if ($role === 'pasien') {
            $keluhan = $request->input('keluhan');
            $nomor_antrian = $request->input('nomor_antrian');
            $pasienData = [
                'user_id' => $user->id,
                'keluhan' => $keluhan,
                'kategori'=> NULL,
                'apoteker_id' =>NULL,
                'dokter_id' =>NULL,
                'nomor_antrian'=>$nomor_antrian,
            ];
    
            Pasien::create($pasienData);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
