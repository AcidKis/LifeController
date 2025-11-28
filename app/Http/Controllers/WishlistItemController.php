<?php

namespace App\Http\Controllers;

use App\Models\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class WishlistItemController extends Controller
{

    public function show(WishlistItem $item)
    {
        try {
            // Проверяем права доступа
            if (!$item->wishlist->canEdit(auth()->user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Доступ запрещен'
                ], 403);
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при получении данных записи: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggle(Request $request, WishlistItem $item)
    {
        try {
            $request->validate([
                'completed' => 'required|boolean'
            ]);

            // Проверяем права доступа
            if (!$item->wishlist->canEdit(auth()->user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Доступ запрещен'
                ], 403);
            }

            $item->update(['completed' => $request->completed]);

            // Получаем обновленную статистику вишлиста
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка сервера: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'wishlist_id' => 'required|exists:wishlists,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'url' => 'nullable|url',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            // Проверяем права доступа к вишлисту
            $wishlist = \App\Models\Wishlist::find($validated['wishlist_id']);
            if (!$wishlist->canEdit(auth()->user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Доступ запрещен'
                ], 403);
            }

            // Обрабатываем загрузку изображения
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imagePath = $request->file('image')->store('wishlist-items', 'public');
                $validated['image'] = $imagePath;
            }

            $item = WishlistItem::create($validated);

            // Получаем обновленную статистику вишлиста
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при создании записи: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, WishlistItem $item)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'url' => 'nullable|url',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            // Проверяем права доступа
            if (!$item->wishlist->canEdit(auth()->user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Доступ запрещен'
                ], 403);
            }

            // Обрабатываем загрузку изображения
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Удаляем старое изображение если оно есть
                if ($item->image) {
                    Storage::disk('public')->delete($item->image);
                }
                $imagePath = $request->file('image')->store('wishlist-items', 'public');
                $validated['image'] = $imagePath;
            }

            $item->update($validated);

            // Получаем обновленную статистику вишлиста
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при обновлении записи: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(WishlistItem $item)
    {
        try {
            // Проверяем права доступа
            if (!$item->wishlist->canEdit(auth()->user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Доступ запрещен'
                ], 403);
            }

            $wishlist = $item->wishlist;

            // Удаляем изображение если оно есть
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }

            $item->delete();

            // Получаем обновленную статистику
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении записи: ' . $e->getMessage()
            ], 500);
        }
    }
}
