<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'description',
        'external_id',
        'price',
        'quantity',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
