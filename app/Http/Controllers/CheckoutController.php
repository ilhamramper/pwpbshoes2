<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Regency;
use App\Models\Village;
use App\Models\Checkout;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $checkoutItems = Checkout::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        $subtotal = Checkout::where('user_id', Auth::id())->sum('total');

        return view('user.product-checkout', compact('checkoutItems', 'subtotal'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'qty' => 'required|array',
        ]);

        $user = auth()->user();

        foreach ($request->qty as $itemId => $qty) {
            $item = Item::find($itemId);

            if (!$item) {
                return redirect()->back()->with('error', 'Invalid item selected.');
            }

            if ($item->stock == 0) {
                Cart::where('user_id', $user->id)->where('item_id', $itemId)->delete();
                return redirect()->back()->with('error', 'Item ' . $item->name . ' is out of stock.');
            }

            if ($qty > $item->stock) {
                return redirect()->back()->with('error', 'Quantity for item ' . $item->name . ' exceeds available stock.');
            }

            if ($qty === null || $qty == 0) {
                return redirect()->back()->with('error', 'Qty cannot be filled in as 0 or empty.');
            }

            $existingCheckout = Checkout::where('user_id', $user->id)
                ->where('item_id', $itemId)
                ->first();

            if ($existingCheckout) {
                $existingCheckout->qty = $qty;
                $existingCheckout->total = $item->discount ? $item->dprice * $qty : $item->price * $qty;
                $existingCheckout->save();
            } else {
                $total = $item->discount ? $item->dprice * $qty : $item->price * $qty;

                Checkout::create([
                    'user_id' => $user->id,
                    'item_id' => $itemId,
                    'qty' => $qty,
                    'total' => $total,
                ]);
            }
        }

        return redirect()->route('product.checkout');
    }

    public function getProvinces()
    {
        $provinces = Province::all();
        return response()->json($provinces);
    }

    public function getRegencies($province_id)
    {
        $regencies = Regency::where('province_id', $province_id)->get();
        return response()->json($regencies);
    }

    public function getDistricts($regency_id)
    {
        $districts = District::where('regency_id', $regency_id)->get();
        return response()->json($districts);
    }

    public function getVillages($district_id)
    {
        $villages = Village::where('district_id', $district_id)->get();
        return response()->json($villages);
    }
}
