<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::paginate(10);
        return response()->json($stores);
    }

    public function show($id)
    {
        $store = Store::find($id);
        if (!$store) {
            return response()->json(["message" => "Can't find store"], 404);
        }
        return response()->json($store);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $store = Auth::user()->stores()->create($validated);
        return response()->json($store);
    }

    public function update(Request $request, $id)
    {
        $store = Store::find($id);
        if (!$store) {
            return response()->json(["message" => "Can't find store"], 404);
        }

        if ($store->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $store->update($validated);
        return response()->json($store);
    }

    public function destroy($id)
    {
        $store = Store::find($id);
        if (!$store) {
            return response()->json(["message" => "Can't find store"], 404);
        }

        if ($store->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $store->delete();
        return response()->json(['message' => 'Store deleted successfully']);
    }
}
