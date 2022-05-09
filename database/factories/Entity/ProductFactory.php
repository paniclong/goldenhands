<?php

declare(strict_types=1);

namespace Database\Factories\Entity;

use App\Entity\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * @return array
     */
    #[ArrayShape(['name' => "string", 'sku' => "array|string"])]
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(20),
            'sku' => $this->faker->words(10, true),
        ];
    }
}
