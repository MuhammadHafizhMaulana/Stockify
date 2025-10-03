<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\ProductAttribute;
use App\Models\StockTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StockifySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Supplier
        $suppliers = [];
        for($i = 0; $i < 15; $i++){
            $suppliers[] = Supplier::create([
                'name' => $faker->company,
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
            ]);
        }

        // Category
        $categories = [];
         for($i = 0; $i < 5; $i++){
            $categories[] = Category::create([
                'name' => ucfirst($faker->word),
                'description' => $faker->sentence(),
            ]);
         }

        // product
        $products = [];
        for($i = 0; $i < 25; $i++){
             $products[] = Product::create([
                'supplier_id' => $suppliers[array_rand($suppliers)]->id,
                'category_id' => $categories[array_rand($categories)]->id,
                'name' => ucfirst($faker->words(3, true)),
                'sku' => strtoupper($faker->bothify('???-#####')),
                'description' => $faker->paragraph(),
                'purchase_price' => $faker->randomFloat(2, 5000, 100000),
                'selling_price' => $faker->randomFloat(2, 10000, 200000),
                'image' => null,
                'minimum_stock' => $faker->numberBetween(5, 20),
                'current_stock' => $faker->numberBetween(10, 250),
             ]);

            // product attribute
             $attributeOptions = [
            ['name' => 'Color', 'values' => ['Red', 'Blue', 'Green', 'Black', 'White']],
            ['name' => 'Size', 'values' => ['S', 'M', 'L', 'XL']],
            ['name' => 'Material', 'values' => ['Cotton', 'Polyester', 'Leather']],
        ];

        foreach ($attributeOptions as $option) {
    ProductAttribute::create([
        'product_id' => $products[$i]->id,
        'name' => $option['name'],
        'value' => $faker->randomElement($option['values']),
    ]);
}
        }

        // stock transaction
         $users = User::all();
        if ($users->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada user di tabel users. Buat user dulu agar stock_transactions bisa diisi.');
            return;
        }

        for ($i = 0; $i < 70; $i++) {
            $product = $products[array_rand($products)];
            $user = $users->random();
            $type = $faker->randomElement(['in', 'out']);
            $quantity = $faker->numberBetween(1, 20);

            // update stock otomatis
            if ($type === 'in') {
                $product->increment('current_stock', $quantity);
            } else {
                $quantity = min($quantity, $product->current_stock); // biar gak minus
                $product->decrement('current_stock', $quantity);
            }

            StockTransaction::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'type' => $type,
                'quantity' => $quantity,
                'status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'notes' => $faker->sentence(),
            ]);
        }
    }

}
