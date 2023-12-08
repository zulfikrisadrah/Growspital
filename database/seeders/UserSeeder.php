<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Apoteker;
use App\Models\Pasien;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            "name"=>"Zulfikri",
            "umur"=>"20",
            "role" => "admin",
            "username"=>"admin",
            "email"=>"admin@gmail.com",
            "password"=>bcrypt("12345678"),
        ]);
        $admin->assignRole("admin");

        $dokter = User::create([
            "name"=>"Andi Adnan",
            "umur"=>"19",
            "role" => "dokter",
            "username"=>"adnan123",
            "email"=>"adnan123@gmail.com",
            "password"=>bcrypt("12345678"),
        ]);
        $dokter->assignRole("dokter");

        $dokter = Dokter::create([
            'spesialis' => 'umum',
            'status' => 'Bertugas',
            'user_id' => $dokter->id,
        ]);

        $apoteker = User::create([
            "name"=>"Yusuf Fikry",
            "umur"=>"19",
            "role" => "apoteker",
            "username"=>"fikry123",
            "email"=>"fikry123@gmail.com",
            "password"=>bcrypt("12345678"),
        ]);
        $apoteker->assignRole("apoteker");

        $apoteker = Apoteker::create([
            'user_id' => $apoteker->id,
        ]);

        $pasien = User::create([
            "name"=>"Mayko Raditya",
            "umur"=>"19",
            "role" => "pasien",
            "username"=>"mayko123",
            "email"=>"mayko123@gmail.com",
            "password"=>bcrypt("12345678"),
        ]);
        $pasien->assignRole("pasien");

        $pasien = Pasien::create([
            'user_id' => $pasien->id,
            'keluhan' => null,
            'kategori'=> null,
            'nomor_antrian' => NULL,
            'apoteker_id' => NULL,
            'dokter_id' => NULL,
        ]);
    }
}
