<?php

namespace App\Http\Controllers;

use App\Models\Apoteker;
use App\Models\Appointment;
use App\Models\Dokter;
use App\Models\MedicalRecord;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Spatie\Permission\Traits\HasRoles;

class UserController extends Controller
{
    public function userindex()
    {
        $users = User::all();
        return view("admin.user-list", compact("users"));
    }
    public function obatindex()
    {
        $obats = Obat::all();
        $dokters = Dokter::with('user')->get();

        return view("admin.user-view", compact("obats", 'dokters'));
    }
    public function medicalrecordindex()
    {
        $medicalrecords = MedicalRecord::all();
        return view("admin.user-list", compact("medicalrecords"));
    }
    public function showuser($id)
    {
        $user = User::find($id);
        return view("admin.user-edit", compact("user"));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'umur' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['dokter', 'apoteker', 'pasien'])],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::find($id);

        $currentRole = $user->getRoleNames()->first();

        $user->update($request->all());

        $requestedRole = $request->input('role');

        if ($user->role == 'pasien' && $user->pasien) {
            $user->pasien->update([
                'keluhan' => $request->input('keluhan'),
                'kategori' => $request->input('kategori'),
            ]);

            Appointment::create(['pasien_id'=>$user->pasien->id]);
        }

        if ($user->role == 'dokter' && $user->dokter) {
            $user->dokter->update([
                'status' => $request->input('status'),
            ]);
        }

        if (!empty($currentRole) && $currentRole !== $requestedRole) {
            $user->removeRole($currentRole);
            $user->assignRole($requestedRole);

            $this->deleteRoleData($currentRole, $user->id);
            $this->insertRoleData($requestedRole, $user->id);
        }
        return redirect()->route('user-list')->with('success', 'User updated successfully.');
    }

    private function deleteRoleData($role, $userId)
    {
        if ($role === 'dokter') {
            Dokter::where('user_id', $userId)->delete();
        } elseif ($role === 'apoteker') {
            Apoteker::where('user_id', $userId)->delete();
        } elseif ($role === 'pasien') {
            Pasien::where('user_id', $userId)->delete();
        }
    }

    private function insertRoleData($role, $userId)
    {
    if ($role === 'dokter') {
            Dokter::create(['user_id' => $userId,]);
        } elseif ($role === 'apoteker') {
            Apoteker::create(['user_id' => $userId,]);
        } elseif ($role === 'pasien') {
            Pasien::create(['user_id' => $userId,]);
        }
    }
    public function editPasien($id)
    {
        $user = User::findOrFail($id);
        $pasien = $user->pasien;
    
        return view('admin.atur-pasien', compact('user', 'pasien'));
    }
    public function updatePasien(Request $request, $id)
    {
        $request->validate([
            'keluhan' => ['required', 'string', 'max:255'],
            'kategori' => ['required', Rule::in(['umum', 'gigi'])],
        ]);
        
        $user = User::find($id);

        $user->pasien->update([
            'keluhan' => $request->input('keluhan'),
            'kategori' => $request->input('kategori'),
        ]);

        Appointment::create([
            'pasien_id' => $user->pasien->id,
        ]);

        return redirect()->route('user-list');
    }

    public function editRiwayat($id)
    {
        $user = User::find($id);
        $dokters = Dokter::with('user')->get();
        $pasiens = Pasien::with('user')->get();

        return view('dokter.periksa-pasien', compact('user', 'pasiens', 'dokters'));
    }

    public function updateRiwayat(Request $request, $id)
    {    
        $user = User::find($id);

        $request->validate([
            'pasien_id' => ['required', 'integer'],
            'dokter_id' => ['required', 'integer'],
            'keluhan' => ['required', 'string', 'max:255'],
            'kategori' => ['required', Rule::in(['umum', 'gigi'])],
            'tindakan' => ['required', 'string', 'max:255'],
            'obat_id' => ['required', 'integer'],
        ]);

        $tindakan = $request->input('tindakan');

        $pasien = Pasien::findOrFail($request->input('pasien_id'));

        $antrian = MedicalRecord::max('id') + 1;

        $pasien->update([
            'keluhan' => $request->input('keluhan'),
            'kategori' => $request->input('kategori'),
            'dokter_id' => auth()->user()->dokter->id,
            'nomor_antrian' => $antrian,
        ]);

        $newAppointment = Appointment::create([
            'pasien_id' => $pasien->id,
            'dokter_id' => auth()->user()->dokter->id,
            'status' => 'Selesai',
        ]);

        $medicalRecord = MedicalRecord::where('appointment_id', $newAppointment->id)->first();

        if ($medicalRecord) {
            $medicalRecord->update([
                'obat_id' => $request->input('obat_id'),
                'tindakan' => $tindakan,
            ]);
        } else {
            MedicalRecord::create([
                'pasien_id' => $pasien->id,
                'dokter_id' => auth()->user()->dokter->id,
                'appointment_id' => $newAppointment->id,
                'obat_id' => $request->input('obat_id'),
                'tindakan' => $tindakan,
                'tgl_berobat' => now(),
            ]);
        }

        Appointment::join('pasiens', 'appointments.pasien_id', '=', 'pasiens.id')
            ->where('appointments.pasien_id', $request->input('pasien_id'))
            ->where('appointments.status', 'Menunggu')
            ->delete();

        return redirect()->route('pasien-list', compact('user', 'tindakan'));
    }

    public function isiRiwayat($id)
    {
        $user = User::find($id);
        $dokters = Dokter::with('user')->get();
        $pasiens = Pasien::with('user')->get();
        
        $medicalRecord = MedicalRecord::create([
            'pasien_id' => $user->pasien->id, 
            'dokter_id' => auth()->user()->dokter->id, 
            'obat_id' => null,
            'tindakan' => null, 
        ]);

        return view('dokter.periksa-pasien', compact('user', 'pasiens', 'dokters'));
    }
    public function kirimRiwayat(Request $request, $id)
    {    
        $user = User::find($id);

        $request->validate([
            'pasien_id' => ['required', 'integer'],
            'dokter_id' => ['required', 'integer'],
            'keluhan' => ['required', 'string', 'max:255'],
            'kategori' => ['required', Rule::in(['umum', 'gigi'])],
            'tindakan' => ['required', 'string', 'max:255'],
            'obat_id' => ['required', 'integer'],
        ]);

        $tindakan = $request->input('tindakan');
    
        $pasien = Pasien::findOrFail($request->input('pasien_id'));
    
        $antrian = MedicalRecord::max('id') + 1;
    
        $pasien->update([
            'keluhan' => $request->input('keluhan'),
            'kategori' => $request->input('kategori'),
            'dokter_id' => auth()->user()->dokter->id,
            'nomor_antrian' => $antrian,
        ]);
    
        $appointment = Appointment::where('pasien_id', $request->input('pasien_id'))->first();
    
        if ($appointment) {
            $appointment->update([
                'status' => 'Selesai',
                'dokter_id' => auth()->user()->dokter->id,
            ]);
    
            $medicalRecord = MedicalRecord::where('appointment_id', $appointment->id)->first();
    
            if ($medicalRecord) {
                $medicalRecord->update([
                    // 'appointment_id' => $pasien->appointment->id,
                    'obat_id' => $request->input('obat_id'),
                    'tindakan' => $request->input('tindakan'),
                    'tgl_berobat' => now(),
                ]);
            } else {

            }
        }
    
        return redirect()->route('pasien-list', compact('user', 'tindakan'));
    }

    public function insertRiwayat(Request $request)
    {
        $request->validate([
            'pasien_id' => ['required', 'integer'],
            'dokter_id' => ['required', 'integer'],
            'keluhan' => ['required', 'string', 'max:255'],
            'kategori' => ['required', Rule::in(['umum', 'gigi'])],
            'tindakan' => ['required', 'string', 'max:255'],
            'obat_id' => ['required', 'integer'],
        ]);

        $pasien = Pasien::findOrFail($request->input('pasien_id'));
        $highestAntrian = Pasien::max('nomor_antrian');

        $antrian = ($highestAntrian !== null) ? $highestAntrian + 1 : 1;

        $pasien->update([
            'keluhan' => $request->input('keluhan'),
            'kategori' => $request->input('kategori'),
            'dokter_id' =>auth()->user()->dokter->id,
            'nomor_antrian' => $antrian,
        ]);

        $appointment = Appointment::create([
            'pasien_id' => $request->input('pasien_id'),
            'dokter_id' =>auth()->user()->dokter->id,
            'status' => 'Selesai'
        ]);

        Appointment::join('pasiens', 'appointments.pasien_id', '=', 'pasiens.id')
            ->where('appointments.pasien_id', $request->input('pasien_id'))
            ->where('appointments.status', 'Menunggu')
            ->delete();

        MedicalRecord::create([
            'pasien_id' => $request->input('pasien_id'),
            'dokter_id' => auth()->user()->dokter->id,
            'obat_id' => $request->input('obat_id'),
            'appointment_id' => $appointment->id, 
            'tgl_berobat' => now(), 
            'tindakan' => $request->input('tindakan'),
        ]);

        $obat = Obat::findOrFail($request->input('obat_id'));
        $obat->stok -= 1;
        $obat->save();

        return redirect()->route('pasien-list');
    }

    public function setBertugas()
    {
        $user = auth()->user();
        
        if ($user->hasRole('dokter')) {
            $dokter = Dokter::where('user_id', $user->id)->first();
            if ($dokter) {
                $dokter->update(['status' => 'Bertugas']);
            }
        }

        return redirect()->back(); 
    }

    public function setTidakBertugas()
    {
        $user = auth()->user();
        
        if ($user->hasRole('dokter')) {
            $dokter = Dokter::where('user_id', $user->id)->first();
            if ($dokter) {
                $dokter->update(['status' => 'Tidak Bertugas']);
            }
        }

        return redirect()->back(); 
    }
}
