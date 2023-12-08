<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DeleteDataController extends Controller
{
    public function deleteuser($id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return redirect()->route('user-list')->with('error', 'User not found.');
        }
    
        $user->delete();
            return redirect()->route('user-list')->with('success', 'User deleted successfully.');
    }

    public function deleteobat($id)
    {
        $obat = Obat::find($id);
    
        if (!$obat) {
            return redirect()->route('obat-list')->with('error', 'Obat not found.');
        }
    
        $obat->delete();
            return redirect()->route('obat-list')->with('success', 'Obat deleted successfully.');
    }
    public function deletepasien($id)
    {
        try {
            $user = User::findOrFail($id);

            $pasien = Pasien::where('user_id', $user->id)->first();
            
            if ($pasien) {
                $pasien->delete();
                return redirect()->back()->with('success', 'Pasien data deleted successfully.');
            } else {
                return redirect()->back()->with('error', 'Pasien data not found.');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting pasien data: ' . $e->getMessage());
        }
    }
}
