<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dataOrderController extends Controller
{
    public function order()
    {
        $orders = Order::orderBy('id_order', 'asc')
            ->get()
            ->groupBy('id_order')
            ->map(function ($group) {
                return $group->first();
            })
            ->map(function ($order) {
                $total = Order::where('id_order', $order->id_order)->sum('total');
                $additionalAmount = ($order->shipping_id == 1) ? 5.00 : (($order->shipping_id == 2) ? 20.00 : 0);
                $order->total = $total + $additionalAmount;

                return $order;
            });

        return view('admin.DataOrder.dataorder', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:1,2,3,4',
        ]);

        Order::where('id_order', $id)->update(['status' => $request->input('status')]);

        return redirect()->route('dataOrder')->with('success', 'Order status updated successfully.');
    }

    public function detail($id)
    {
        try {
            $order = Order::where('id_order', $id)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('dataOrder')->with('error', 'Data order not found.');
        }

        $orderNumber = $order->id_order;
        $date = $order->created_at->format('H:i:s Y-m-d');
        $shippingCost = ($order->shipping_id == 1) ? 5.00 : (($order->shipping_id == 2) ? 20.00 : 0);
        $total = Order::where('id_order', $orderNumber)
            ->sum('total') + $shippingCost;
        $paymentMethod = ($order->payment == 'COD') ? 'Cash On Delivery (COD)' : $order->payment;
        $province = DB::table('provinces')->where('id', $order->province_id)->value('name');
        $regency = DB::table('regencies')->where('id', $order->regency_id)->value('name');
        $district = DB::table('districts')->where('id', $order->district_id)->value('name');
        $village = DB::table('villages')->where('id', $order->village_id)->value('name');
        $address = $order->address;
        $subtotal = Order::where('id_order', $orderNumber)
            ->sum('total');
        $shippingOption = ($order->shipping_id == 1) ? 'Regular Shipping: $5.00' : (($order->shipping_id == 2) ? 'Fast Shipping: $20.00' : 'Unknown Shipping');
        $orderDetails = Order::where('id_order', $orderNumber)
            ->get(['item_id', 'qty', 'total']);
        $orderDetails = $orderDetails->map(function ($item) {
            $itemName = Item::where('id', $item->item_id)->value('name');
            return [
                'item_name' => $itemName,
                'qty' => $item->qty,
                'total' => $item->total,
            ];
        });

        return view('admin.DataOrder.detail', [
            'order' => $order,
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
