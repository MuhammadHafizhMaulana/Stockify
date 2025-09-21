<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User;

class StockTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\StockTransactionFactory> */
    use HasFactory;

    protected $fillable = [
        'type',
        'quantity',
        'status',
        'notes',
        'product_id',
        'user_id'
    ];

    public function product() : BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function user() : BelongsTo{
        return $this->belongsTo(User::class);
    }
}
