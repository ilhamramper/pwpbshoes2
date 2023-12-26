<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'image', 'stock', 'price', 'discount', 'description',
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
