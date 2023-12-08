<?php
// UserFactory.php
namespace Database\Factories;

use App\Models\User;
use App\Models\Dokter;
use App\Models\Apoteker;
use App\Models\Pasien;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'umur' => $this->faker->numberBetween(20, 40),
            'username' => $this->faker->unique()->userName,
            'role' => $this->faker->randomElement(['pasien', 'dokter', 'apoteker']),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => null,
            'password' => Hash::make('password'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole($user->role);
            $this->handleRoleData($user);
        });
    }

    protected function handleRoleData(User $user)
    {
        $role = $user->role;
        $spesialis = ['umum', 'gigi'];
        $status = ['Bertugas', 'Tidak Bertugas'];

        switch ($role) {
            case 'dokter':
                Dokter::create([
                    'user_id' => $user->id,
                    'spesialis' => $this->faker->randomElement($spesialis), 
                    'status' => $this->faker->randomElement($status),  
                ]);
                break;

            case 'apoteker':
                Apoteker::create([
                    'user_id' => $user->id
                ]);
                break;

            case 'pasien':
                Pasien::create([
                    'user_id' => $user->id,
                    'apoteker_id' => null,
                    'kategori' => null,
                    'dokter_id' => null,
                    'keluhan' => null,
                    'nomor_antrian' => null,
                ]);
                break;
        }
    }
}