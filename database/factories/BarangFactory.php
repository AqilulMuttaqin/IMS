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
            'kode_js' => $this->faker->unique()->numerify('JS###'),
            'nama' => $this->faker->name,
            'harga' => $this->faker->randomFloat(2, 1000, 100000),
            'min_stok' => $this->faker->numberBetween(1, 100),
            'max_stok' => $this->faker->numberBetween(101, 200),
        ];
    }
}
