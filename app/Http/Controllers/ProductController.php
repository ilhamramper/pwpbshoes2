<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function detail($id)
    {
        $item = Item::findOrFail($id);
        return view('user.product-detail',compact('item'));
    }
}
