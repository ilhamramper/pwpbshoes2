<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop(Request $request)
    {
        $sortingOption = $request->input('sorting_option', 1);
        $itemsPerPage = $request->input('items_per_page', 10);

        $query = $this->getSortedItems($sortingOption);
        $items = $query->paginate($itemsPerPage);

        return view('user.shop', compact('items'));
    }

    private function getSortedItems($sortingOption)
    {
        $query = Item::query();

        switch ($sortingOption) {
            case 1:
                $query->orderBy('name', 'asc');
                break;
            case 2:
                $query->orderBy('name', 'desc');
                break;
            case 3:
                $query->orderBy('price', 'asc');
                break;
            case 4:
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        return $query;
    }
}
