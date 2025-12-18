<?php

namespace App\Http\Controllers;

use App\Models\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class WishlistItemController extends Controller
{
    public function show(WishlistItem $item)
    {
        if (!Gate::allows('view', $item->wishlist)) {
            abort(403);
        }

        return response()->json([
            'success' => true,
            'item' => [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'price' => $item->price,
                'url' => $item->url,
                'image_url' => $item->image ? Storage::url($item->image) : null,
                'completed' => $item->completed,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ]
        ]);
    }

    public function toggle(Request $request, WishlistItem $item)
    {
        if (!Gate::allows('update', $item->wishlist)) {
            abort(403);
        }

        $request->validate([
            'completed' => 'required|boolean'
        ]);

        $item->update(['completed' => $request->completed]);

        $wishlist = $item->wishlist->load('items');
        $totalItems = $wishlist->items->count();
        $completedItems = $wishlist->items->where('completed', true)->count();
        $progressPercentage = $totalItems > 0
            ? round(($completedItems / $totalItems) * 100)
            : 0;

        return response()->json([
            'success' => true,
            'progress' => [
                'completed' => $completedItems,
                'total' => $totalItems,
                'percentage' => $progressPercentage
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'wishlist_id' => 'required|exists:wishlists,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $wishlist = \App\Models\Wishlist::find($validated['wishlist_id']);
        
        if (!Gate::allows('addItem', $wishlist)) {
            abort(403);
        }

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('wishlist-items', 'public');
            $validated['image'] = $imagePath;
        }

        $item = WishlistItem::create($validated);

        $wishlist->load('items');
        $totalItems = $wishlist->items->count();
        $completedItems = $wishlist->items->where('completed', true)->count();
        $progressPercentage = $totalItems > 0
            ? round(($completedItems / $totalItems) * 100)
            : 0;

        return response()->json([
            'success' => true,
            'message' => 'Запись успешно добавлена!',
            'item' => [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'price' => $item->price,
                'url' => $item->url,
                'image_url' => $item->image ? Storage::url($item->image) : null,
                'completed' => $item->completed,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ],
            'progress' => [
                'completed' => $completedItems,
                'total' => $totalItems,
                'percentage' => $progressPercentage
            ]
        ]);
    }

    public function update(Request $request, WishlistItem $item)
    {
        if (!Gate::allows('update', $item->wishlist)) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $imagePath = $request->file('image')->store('wishlist-items', 'public');
            $validated['image'] = $imagePath;
        }

        $item->update($validated);

        $wishlist = $item->wishlist->load('items');
        $totalItems = $wishlist->items->count();
        $completedItems = $wishlist->items->where('completed', true)->count();
        $progressPercentage = $totalItems > 0
            ? round(($completedItems / $totalItems) * 100)
            : 0;

        return response()->json([
            'success' => true,
            'message' => 'Запись успешно обновлена!',
            'item' => [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'price' => $item->price,
                'url' => $item->url,
                'image_url' => $item->image ? Storage::url($item->image) : null,
                'completed' => $item->completed,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ],
            'progress' => [
                'completed' => $completedItems,
                'total' => $totalItems,
                'percentage' => $progressPercentage
            ]
        ]);
    }

    public function destroy(WishlistItem $item)
    {
        if (!Gate::allows('update', $item->wishlist)) {
            abort(403);
        }

        $wishlist = $item->wishlist;

        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        $wishlist->load('items');
        $totalItems = $wishlist->items->count();
        $completedItems = $wishlist->items->where('completed', true)->count();
        $progressPercentage = $totalItems > 0
            ? round(($completedItems / $totalItems) * 100)
            : 0;

        return response()->json([
            'success' => true,
            'progress' => [
                'completed' => $completedItems,
                'total' => $totalItems,
                'percentage' => $progressPercentage
            ]
        ]);
    }
}