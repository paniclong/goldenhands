<?php

namespace Database\Seeders;

use App\Entity\Product;
use App\Entity\ProductConfig;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         ProductConfig::factory(10)->create()->each(static function (ProductConfig $productConfig) {
            Product::factory()->create(['config_id' => $productConfig->getId()]);
         });
    }
}
