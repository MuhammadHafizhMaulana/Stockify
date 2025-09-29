<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
     protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'image'
    ];

    public function stockTransaction() : HasMany {
        return $this->hasMany(StockTransaction::class);
    }

    public function activityLog() : HasMany {
        return $this->hasMany(ActivityLog::class);
    }
}
