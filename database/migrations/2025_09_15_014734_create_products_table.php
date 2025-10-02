<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained(
                table: 'suppliers',
                indexName: 'product_supplier_id',
            );
            $table->foreignId('category_id')->constrained(
                table: 'categories',
                indexName: 'product_categories_id',
            );
            $table->string('name');
            $table->string('sku');
            $table->text('description');
            $table->decimal('purchase_price', 20,2);
            $table->decimal('selling_price', 20, 2);
            $table->string('image')->nullable();
            $table->integer('minimum_stock');
            $table->integer('current_stock')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
