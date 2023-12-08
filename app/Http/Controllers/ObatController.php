<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class ObatController extends Controller
{
    public function showobat($id)
    {
        $obat = Obat::find($id);
        return view("apoteker.obat-edit", compact("obat"));
    }

    public function update(Request $request, $id)
    {
        $obat = Obat::find($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('obats')->ignore($obat->id)],
            'deskripsi' => ['required', 'string', 'max:255'],
            'tipe' => ['required', Rule::in(['keras', 'biasa'])],
            'stok' => ['required', 'integer'],
        ]);

        $obat = Obat::find($id);
        $obat->update($request->all());
        return redirect()->route("obat-list");
    }
}

