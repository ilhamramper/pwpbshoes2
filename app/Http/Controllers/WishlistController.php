<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class WishlistController extends Controller
{
    public function wishlist()
    {       
        $wishlistItems = Wishlist::where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

        return view('user.wishlist', compact('wishlistItems'));
    }

    public function store($id)
    {
        if (!Auth::check()) {
            return redirect('login')->withErrors([
                'wishlist' => 'You must login first.'
            ]);
        }

        $existingWishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('item_id', $id)
            ->first();

        if ($existingWishlistItem) {
            return Redirect::back()->with('error', 'Item is already in your wishlist.');
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'item_id' => $id,
        ]);

        Session::flash('success', 'Item added to wishlist successfully.');

        return Redirect::back();
    }

    public function destroy($id)
    {
        $wishlistItem = Wishlist::findOrFail($id);

        $wishlistItem->delete();

        Session::flash('success', 'Item removed from wishlist successfully.');

        return Redirect::back();
    }
}
