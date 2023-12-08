<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Obat;
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


class InsertDataController extends Controller
{
    public function storeuser(Request $request)
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
                'kategori' => null,
                'apoteker_id' =>NULL,
                'dokter_id' =>NULL,
                'nomor_antrian'=>$nomor_antrian,
            ];
    
            Pasien::create($pasienData);
        }
        event(new Registered($user));
        
        $users = User::all();
        $dokters = Dokter::with('user')->get();
        $apotekers = Apoteker::with('user')->get();
        $pasiens = Pasien::with('user')->get();
        
        return view("admin.user-list", compact("users", "dokters", 'apotekers', 'pasiens'));
    }

    public function storeobat(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('obats')],
            'deskripsi' => ['required', 'string', 'max:255'],
            'tipe' => ['required', Rule::in(['keras', 'biasa'])],
            'stok' => ['required', 'integer'],
        ]);

        $obat = new Obat([
            'name' => $request->input('name'),
            'deskripsi' => $request->input('deskripsi'),
            'tipe' => $request->input('tipe'),
            'stok' => $request->input('stok'),
        ]);

        $obat->apoteker_id = auth()->user()->apoteker->id;

        $obat->save();

        return redirect()->route('obat-list'); 
    }
}
