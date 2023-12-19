<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $table = 'checkouts';
    protected $fillable = ['user_id', 'item_id', 'qty', 'total'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
