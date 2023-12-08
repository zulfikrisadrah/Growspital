<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\MedicalRecord;
use App\Models\Obat;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Apoteker;
use App\Models\Pasien;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // MedicalRecord::factory(10)->create();
        User::factory(20)->create();
        Obat::factory(5)->create();
        // $this->seedUsersWithRoles();

        // Generate data for other tables if needed
    }

    // private function seedUsersWithRoles(): void
    // {
    //     $roles = ['dokter', 'apoteker', 'pasien'];

    //     foreach ($roles as $roleName) {
    //         $role = Role::where('name', $roleName)->first();

    //         User::factory(10)->create()->each(function ($user) use ($role) {
    //             $user->assignRole($role->name);

    //             if ($role->name === 'dokter') {
    //                 $this->seedDokter($user);
    //             } elseif ($role->name === 'apoteker') {
    //                 $this->seedApoteker($user);
    //             } elseif ($role->name === 'pasien') {
    //                 $this->seedPasien($user);
    //             }
    //         });
    //     }
    // }
    // private function seedDokter(User $user): void
    // {
    //     Dokter::create([
    //         'user_id' => $user->id,
    //         'spesialis' => 'umum',
    //         'status' => 'Tidak Bertugas',
    //     ]);
    // }

    // private function seedApoteker(User $user): void
    // {
    //     Apoteker::create([
    //         'user_id' => $user->id,
    //         // Tambahkan atribut lain yang khusus untuk apoteker
    //     ]);
    // }

    // private function seedPasien(User $user): void
    // {
    //     Pasien::create([
    //         'user_id' => $user->id,
    //         'keluhan' => '-',
    //         'apoteker_id' => null,
    //         'dokter_id' => null,
    //         'nomor_antrian' => null,
    //     ]);
    // }
}

