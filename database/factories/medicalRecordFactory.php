<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\medicalRecord>
 */
class medicalRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\MedicalRecord::class;

    public function definition()
    {
        return [
            // 'pasien_id' => $this->faker->optional()->randomNumber(),
            // 'dokter_id' => $this->faker->optional()->randomNumber(),
            // 'obat_id' => $this->faker->optional()->randomNumber(),
            'tindakan' => null,
            'tgl_berobat' => null,
        ];
    }
}
