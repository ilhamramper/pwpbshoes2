<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'id_order',
        'user_id',
        'item_id',
        'name',
        'phone',
        'email',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'address',
        'shipping_id',
        'qty',
        'total',
        'payment',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'order_id', 'id_order');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
