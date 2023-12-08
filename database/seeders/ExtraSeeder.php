<?php

namespace Database\Seeders;

use App\Models\MedicalRecord;
use App\Models\Obat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Obat::create([
            "name"=>"Paramex",
            "deskripsi"=>"Obat sakit kepala",
            "tipe" => "keras",
            "stok"=>"40",
            'apoteker_id' => NULL,
            'pasien_id' => NULL,
        ]);

        // MedicalRecord::create([
        //     "tindakan"=>NULL,
        //     "tgl_berobat"=>NULL,
        //     'dokter_id' => NULL,
        //     'pasien_id' => NULL,
        //     'obat_id' => NULL,
        // ]);

    }
}
