<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Obat>
 */
class ObatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Obat::class;

    public function definition(): array
    {
        $tipe = ['keras', 'biasa'];

        return [
            // 'pasien_id' => $this->faker->optional()->randomNumber(),
            // 'apoteker_id' => $this->faker->optional()->randomNumber(),
            'name' => $this->faker->word(),
            'deskripsi' => $this->faker->sentence,
            'tipe' => $this->faker->randomElement($tipe),
            'stok' => $this->faker->numberBetween(1, 100),
        ];
    }
}
