<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'purchase_price',
        'selling_price',
        'image',
        'minimum_stock',
        'supplier_id',
        'category_id',
        'current_stock'
    ];

    public function productAttribute() : HasMany {
        return $this->hasMany(ProductAttribute::class);
    }

    public function stockTransaction() : HasMany {
        return $this->hasMany(StockTransaction::class);
    }

    public function supplier() : BelongsTo {
        return $this->belongsTo( Supplier::class);
    }
    public function category() :BelongsTo {
        return $this->belongsTo(Category::class);
    }
}
