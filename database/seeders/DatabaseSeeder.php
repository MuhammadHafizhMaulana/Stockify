<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);
        User::factory()->create([
            'name' => 'staff',
            'email' => 'staff@example.com',
            'role' => 'staff',
            'password' => Hash::make('password123'),
        ]);
        User::factory()->create([
            'name' => 'manajer',
            'email' => 'manajer@example.com',
            'role' => 'manajer',
            'password' => Hash::make('password123'),
        ]);

        Category::factory()->create([
            'name' => 'elektronik',
            'description' => 'Barang barang elektronik',

        ]);

        Category::factory()->create([
            'name' => 'pakaian',
            'description' => 'pakaian manusia dari celana hingga baju',

        ]);

        Category::factory()->create([
            'name' => 'rumah tangga',
            'description' => 'segala kebutuhan rumah tangga',

        ]);

        Supplier::factory()->create([
            'name' => 'Arya Sadewa',
            'address' => 'purworejo',
            'email' => 'arya@example.com',
            'phone' => '08982676321',

        ]);

        Supplier::factory()->create([
            'name' => 'Muhammad Hafizh',
            'address' => 'purworejo',
            'email' => 'hafizh@example.com',
            'phone' => '0812345',

        ]);

        Product::factory()->create([
            'supplier_id' => 1,
            'category_id' => 1,
            'name' => 'TV Sony',
            'sku' => 'sku123',
            'description' => 'Ini adalah TV',
            'purchase_price' => '30000',
            'selling_price' => '30000',
            'minimum_stock' => '100',

        ]);
    }
}
