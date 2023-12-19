<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function item()
    {
        $items = Item::orderBy('name', 'asc')
            ->get();

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
            'stock' => 'required|integer',
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
        $item->stock = $request->stock;
        $item->price = $this->convertToDatabaseCurrency($request->price);
        $item->discount = $request->discount ?? null;
        $item->dprice = $item->discount !== null ? $item->price - ($item->price * $item->discount / 100) : null;

        $item->save();

        return redirect()->route('dataItem')->with('success', 'Item berhasil disimpan');
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
            'stock' => 'required|integer',
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
        $item->stock = $request->stock;
        $item->price = $this->convertToDatabaseCurrency($request->price);
        $item->discount = $request->discount ?? null;
        $item->dprice = $item->discount !== null ? $item->price - ($item->price * $item->discount / 100) : null;
        $item->save();

        return redirect()->route('dataItem')->with('success', 'Item berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        Storage::delete('public/item_images/' . basename($item->image));
        $item->delete();

        return redirect()->route('dataItem')->with('success', 'Item berhasil dihapus');
    }

    private function convertToDatabaseCurrency($input)
    {
        $cleanedInput = str_replace(['$', ','], '', $input);
        $floatValue = floatval($cleanedInput);

        return $floatValue;
    }
}
