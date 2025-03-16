<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingItem;

class ShoppingItemController extends Controller
{
    /**
     * Tampilkan semua item belanja.
     */
    public function index()
    {
        return response()->json(ShoppingItem::all(), 200);
    }

    /**
     * Tambah item baru ke daftar belanja.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'integer|min:1',
            'purchased' => 'boolean'
        ]);

        $item = ShoppingItem::create($validatedData);

        return response()->json($item, 201);
    }

    /**
     * Tampilkan detail item berdasarkan ID.
     */
    public function show($id)
    {
        $item = ShoppingItem::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        return response()->json($item, 200);
    }

    /**
     * Update item berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $item = ShoppingItem::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'quantity' => 'integer|min:1',
            'purchased' => 'boolean'
        ]);

        $item->update($validatedData);

        return response()->json($item, 200);
    }

    /**
     * Hapus item dari daftar belanja.
     */
    public function destroy($id)
    {
        $item = ShoppingItem::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->delete();
        return response()->json(['message' => 'Item deleted'], 200);
    }
}
