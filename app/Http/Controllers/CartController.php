<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function cart()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.cart', compact('cartItems'));
    }

    public function store($id)
    {
        if (!Auth::check()) {
            return redirect('login')->withErrors([
                'cart' => 'You must login first.'
            ]);
        }

        $existingCartItem = Cart::where('user_id', Auth::id())
            ->where('item_id', $id)
            ->first();

        if ($existingCartItem) {
            return Redirect::back()->with('error', 'Item is already in your cart.');
        }

        $item = Item::find($id);

        if ($item->stock <= 0) {
            return Redirect::back()->with('error', 'Item is out of stock.');
        }

        Cart::create([
            'user_id' => Auth::id(),
            'item_id' => $id,
        ]);

        Session::flash('success', 'Item added to cart successfully.');

        return Redirect::back();
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $cartItem = Cart::findOrFail($id);
            $cartItem->delete();

            Checkout::where('user_id', $cartItem->user_id)
                ->where('item_id', $cartItem->item_id)
                ->delete();
        });

        Session::flash('success', 'Item removed from cart successfully.');

        return Redirect::back();
    }

    public function confirmation()
    {
        $orderData = Order::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$orderData) {
            return redirect()->back()->with('error', 'No order data found.');
        }

        $orderNumber = $orderData->id_order;
        $date = $orderData->updated_at;
        $shippingCost = ($orderData->shipping_id == 1) ? 5.00 : (($orderData->shipping_id == 2) ? 20.00 : 0);
        $total = Order::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->where('id_order', $orderNumber)
            ->sum('total') + $shippingCost;
        $paymentMethod = ($orderData->payment == 'COD') ? 'Cash On Delivery (COD)' : $orderData->payment;
        $province = DB::table('provinces')->where('id', $orderData->province_id)->value('name');
        $regency = DB::table('regencies')->where('id', $orderData->regency_id)->value('name');
        $district = DB::table('districts')->where('id', $orderData->district_id)->value('name');
        $village = DB::table('villages')->where('id', $orderData->village_id)->value('name');
        $address = $orderData->address;
        $subtotal = Order::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->where('id_order', $orderNumber)
            ->sum('total');
        $shippingOption = ($orderData->shipping_id == 1) ? 'Regular Shipping: $5.00' : (($orderData->shipping_id == 2) ? 'Fast Shipping: $20.00' : 'Unknown Shipping');
        $orderDetails = Order::where('user_id', auth()->user()->id)
            ->where('id_order', $orderNumber)
            ->orderBy('created_at', 'desc')
            ->get(['item_id', 'qty', 'total']);
        $orderDetails = $orderDetails->map(function ($item) {
            $itemName = Item::where('id', $item->item_id)->value('name');
            return [
                'item_name' => $itemName,
                'qty' => $item->qty,
                'total' => $item->total,
            ];
        });

        return view('user.confirmation', [
            'orderData' => $orderData,
            'orderNumber' => $orderNumber,
            'date' => $date,
            'total' => $total,
            'paymentMethod' => $paymentMethod,
            'province' => $province,
            'regency' => $regency,
            'district' => $district,
            'village' => $village,
            'address' => $address,
            'subtotal' => $subtotal,
            'shippingOption' => $shippingOption,
            'orderDetails' => $orderDetails,
        ]);
    }
}
