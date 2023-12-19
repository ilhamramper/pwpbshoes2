<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (
            $request->input('province_input') == 0 ||
            $request->input('regency_input') == 0 ||
            $request->input('district_input') == 0 ||
            $request->input('village_input') == 0
        ) {
            return redirect()->back()->with('error', 'Invalid address data.')->withInput();
        }

        if (
            $request->input('shipping_id') == 0
        ) {
            return redirect()->back()->with('error', 'Invalid shipping.')->withInput();
        }

        if (
            $request->input('payment') == 0
        ) {
            return redirect()->back()->with('error', 'Invalid payment.')->withInput();
        }

        $checkouts = Checkout::where('user_id', auth()->user()->id)->get();

        if ($checkouts->isEmpty()) {
            return redirect()->route('cart')->with('error', 'No items to checkout.');
        }

        $lastOrder = Order::latest()->first();

        if ($lastOrder) {
            $lastOrderId = (int) substr($lastOrder->id_order, 3);
            $orderNumber = $lastOrderId + 1;
        } else {
            $orderNumber = 1;
        }

        $orderId = 'ORD' . str_pad($orderNumber, 4, '0', STR_PAD_LEFT);

        $name = auth()->user()->name;
        $phone = $request->input('phone');
        $email = auth()->user()->email;
        $address = $request->input('address');
        $provinceId = $request->input('province_input');
        $regencyId = $request->input('regency_input');
        $districtId = $request->input('district_input');
        $villageId = $request->input('village_input');
        $shippingId = $request->input('shipping_id');
        $payment = $request->input('payment');

        foreach ($checkouts as $checkout) {
            $item = Item::find($checkout->item_id);

            if ($item->stock !== 0) {
                if ($item->stock < $checkout->qty) {
                    return redirect()->route('cart')->with('error', 'Quantity for item ' . $item->name . ' exceeds available stock.');
                }
            } else {
                Checkout::where('user_id', auth()->user()->id)->where('item_id', $checkout->item_id)->delete();
                Cart::where('user_id', auth()->user()->id)->where('item_id', $checkout->item_id)->delete();

                return redirect()->route('cart')->with('error', 'Item ' . $item->name . ' is out of stock.');
            }

            Order::create([
                'id_order' => $orderId,
                'user_id' => $checkout->user_id,
                'item_id' => $checkout->item_id,
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'address' => $address,
                'province_id' => $provinceId,
                'regency_id' => $regencyId,
                'district_id' => $districtId,
                'village_id' => $villageId,
                'shipping_id' => $shippingId,
                'qty' => $checkout->qty,
                'total' => $checkout->total,
                'payment' => $payment,
            ]);

            Item::where('id', $checkout->item_id)->decrement('stock', $checkout->qty);
        }

        Checkout::where('user_id', auth()->user()->id)->delete();
        Cart::where('user_id', auth()->user()->id)->delete();

        return redirect()->route('confirmation')->with('success', 'Checkout successfully.');
    }
}
