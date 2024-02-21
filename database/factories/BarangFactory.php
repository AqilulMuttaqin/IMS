<?php

namespace Database\Factories;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Barang::class;

    public function definition()
    {
        return [
            'no_js' => $this->faker->unique()->numerify('JS###'),
            'nama' => $this->faker->name,
            'stok' => $this->faker->numberBetween(1, 100),
        ];
    }
}
