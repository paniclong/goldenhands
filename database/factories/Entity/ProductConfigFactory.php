<?php

declare(strict_types=1);

namespace Database\Factories\Entity;

use App\Entity\ProductConfig;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class ProductConfigFactory extends Factory
{
    protected $model = ProductConfig::class;

    /**
     * @return array
     */
    #[ArrayShape(['description' => "string", 'price' => "float", 'currency' => "mixed", 3 => "string"])]
    public function definition(): array
    {
        return [
            'description' => $this->faker->text(50),
            'price' => $this->faker->randomFloat(2, 0, 100000),
            'currency' => $this->faker->randomElement(['RUB', 'EUR', 'USD']),
        ];
    }
}
