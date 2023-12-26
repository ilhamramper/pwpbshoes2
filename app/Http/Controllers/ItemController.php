<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function item()
    {
        $items = Item::orderBy('name', 'asc')->get();

        foreach ($items as $item) {
            $item->totalStock = $this->calculateTotalStock($item->id);
        }

        return view('admin.DataItem.dataitem', compact('items'));
    }

    public function create()
    {
        return view('admin.DataItem.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => [
                'required',
                'regex:/^[0-9]+(?:\.[0-9]{1,2})?$/'
            ],
            'discount' => [
                'nullable',
                'integer',
                'min:1',
                'max:99',
            ],
        ]);

        $imageName = $request->image->store('item_images', 'public');

        $item = new Item();
        $item->name = $request->name;
        $item->description = $request->description;
        $item->image = $imageName;
        $item->price = $this->convertToDatabaseCurrency($request->price);
        $item->discount = $request->discount ?? null;
        $item->dprice = $item->discount !== null ? $item->price - ($item->price * $item->discount / 100) : null;

        $item->save();

        return redirect()->route('dataItem')->with('success', 'Item added successfully.');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('admin.DataItem.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => [
                'required',
                'regex:/^[0-9]+(?:\.[0-9]{1,2})?$/',
            ],
            'discount' => [
                'nullable',
                'integer',
                'min:1',
                'max:99',
            ],
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/item_images/' . basename($item->image));
            $imageName = $request->file('image')->store('item_images', 'public');
            $item->image = $imageName;
        }

        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $this->convertToDatabaseCurrency($request->price);
        $item->discount = $request->discount ?? null;
        $item->dprice = $item->discount !== null ? $item->price - ($item->price * $item->discount / 100) : null;
        $item->save();

        return redirect()->route('detailItem', ['id' => $item->id])->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        Stock::where('item_id', $id)->delete();
        Storage::delete('public/item_images/' . basename($item->image));
        $item->delete();

        return redirect()->route('dataItem')->with('success', 'Item deleted successfully.');
    }

    private function convertToDatabaseCurrency($input)
    {
        $cleanedInput = str_replace(['$', ','], '', $input);
        $floatValue = floatval($cleanedInput);

        return $floatValue;
    }

    public function detail($id)
    {
        try {
            $item = Item::where('id', $id)->firstOrFail();
            $stocks = Stock::where('item_id', $id)
                ->orderBy('size', 'asc')
                ->get();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('dataItem')->with('error', 'Data item not found.');
        }

        $id = $item->id;
        $name = $item->name;
        $description = $item->description;
        $image = $item->image;
        $price = $item->price;
        $dprice = $item->dprice;
        $discount = $item->discount;

        return view('admin.DataItem.detail', [
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'image' => $image,
            'price' => $price,
            'dprice' => $dprice,
            'discount' => $discount,
            'stocks' => $stocks,
        ]);
    }

    public function addStock(Request $request)
    {
        $request->validate([
            'size' => 'required|integer',
            'stock' => 'required|integer',
            'item_id' => 'required|integer',
        ]);

        $existingStock = Stock::where('size', $request->size)
            ->where('item_id', $request->item_id)
            ->first();

        if ($existingStock) {
            return redirect()->back()->with('error', 'Size already exists.');
        }

        Stock::create([
            'size' => $request->size,
            'stock' => $request->stock,
            'item_id' => $request->item_id,
        ]);

        return redirect()->route('detailItem', ['id' => $request->item_id])->with('success', 'Stock added successfully.');
    }

    public function updateStock(Request $request)
    {
        $request->validate([
            'editSize' => 'required|integer',
            'editStock' => 'required|integer',
            'editItemId' => 'required|integer',
        ]);

        try {
            $stock = Stock::findOrFail($request->editStockId);

            $stock->item_id = $request->editItemId;
            $stock->stock = $request->editStock;
            $stock->stock = $request->editStock;
            $stock->save();

            return redirect()->route('detailItem', ['id' => $stock->item_id])->with('success', 'Stock updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('dataItem')->with('error', 'Stock not found.');
        }
    }

    public function deleteStock($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('detailItem', ['id' => $stock->item_id])->with('success', 'Stock deleted successfully.');
    }

    public function calculateTotalStock($itemId)
    {
        return Stock::where('item_id', $itemId)->sum('stock');
    }
}
