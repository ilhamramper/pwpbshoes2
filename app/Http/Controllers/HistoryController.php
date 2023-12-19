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
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function history()
    {
        $history = Order::select('id_order', 'payment', 'status', DB::raw('(SUM(total) + 
                    CASE 
                        WHEN MAX(shipping_id) = 1 THEN 5.00
                        WHEN MAX(shipping_id) = 2 THEN 20.00
                        ELSE 0
                    END) as total_amount'), DB::raw('MAX(created_at) as created_at'))
            ->where('user_id', Auth::id())
            ->groupBy('id_order', 'payment', 'status')
            ->orderBy('id_order', 'desc')
            ->get();

        return view('user.history', ['history' => $history]);
    }

    public function detail($id)
    {
        try {
            $order = Order::where('id_order', $id)->firstOrFail();
            
            if ($order->user_id != auth()->user()->id) {
                return redirect()->route('history')->with('error', 'Unauthorized access.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('history')->with('error', 'Order not found.');
        }

        $total = $this->calculateTotal($order);
        $provinceName = $this->getProvinceName($order->province_id);
        $regencyName = $this->getRegencyName($order->regency_id);
        $districtName = $this->getDistrictName($order->district_id);
        $villageName = $this->getVillageName($order->village_id);
        $orderNumber = $order->id_order;
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
        $shippingCost = ($order->shipping_id == 1) ? 5.00 : (($order->shipping_id == 2) ? 20.00 : 0);
        $subtotal = Order::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->where('id_order', $orderNumber)
            ->sum('total');
        $shippingOption = ($order->shipping_id == 1) ? 'Regular Shipping: $5.00' : (($order->shipping_id == 2) ? 'Fast Shipping: $20.00' : 'Unknown Shipping');

        return view('user.detail-history', compact('order', 'total', 'provinceName', 'regencyName', 'districtName', 'villageName', 'orderDetails', 'total', 'subtotal', 'shippingOption'));
    }

    private function calculateTotal(Order $order)
    {
        if ($order->count() == 1) {
            return $order->total + $this->getAdditionalAmount($order);
        }

        $total = Order::where('id_order', $order->id_order)->sum('total');
        $additionalAmount = $this->getAdditionalAmount($order);

        return $total + $additionalAmount;
    }

    private function getAdditionalAmount(Order $order)
    {
        return ($order->shipping_id == 1) ? 5.00 : 20.00;
    }

    private function getProvinceName($provinceId)
    {
        $province = Province::find($provinceId);
        return $province ? $province->name : 'Unknown Province';
    }

    private function getRegencyName($regencyId)
    {
        $regency = Regency::find($regencyId);
        return $regency ? $regency->name : 'Unknown Regency';
    }

    private function getDistrictName($districtId)
    {
        $district = District::find($districtId);
        return $district ? $district->name : 'Unknown District';
    }

    private function getVillageName($villageId)
    {
        $village = Village::find($villageId);
        return $village ? $village->name : 'Unknown Village';
    }
}
