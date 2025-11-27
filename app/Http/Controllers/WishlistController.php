<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Получаем вишлисты, доступные текущему пользователю
        $wishlists = Wishlist::with(['user', 'items', 'editorUsers', 'viewerUsers'])
            ->where(function ($query) {
                // Вишлисты пользователя
                $query->where('user_id', Auth::id())
                      // Или публичные вишлисты
                      ->orWhere('visibility', \App\Enums\Visibility::PUBLIC)
                      // Или вишлисты, где пользователь является редактором/зрителем
                      ->orWhereHas('editorUsers', function ($q) {
                          $q->where('user_id', Auth::id());
                      })
                      ->orWhereHas('viewerUsers', function ($q) {
                          $q->where('user_id', Auth::id());
                      });
            })
            ->active()
            ->ordered()
            ->get();

        // Подсчитываем статистику для каждого вишлиста
        $wishlists->each(function ($wishlist) {
            $wishlist->total_items = $wishlist->items->count();
            $wishlist->completed_items = $wishlist->items->where('completed', true)->count();
            $wishlist->progress_percentage = $wishlist->total_items > 0 
                ? round(($wishlist->completed_items / $wishlist->total_items) * 100) 
                : 0;
        });

        return view('wishlists.index', compact('wishlists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('wishlists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'visibility' => 'required|in:public,private,shared',
            'edit_permission' => 'required|in:owner,selected,all',
        ]);

        $wishlist = Wishlist::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'visibility' => $validated['visibility'],
            'edit_permission' => $validated['edit_permission'],
            'sort_order' => 0,
            'is_archived' => false,
        ]);

        return redirect()->route('wishlists.index')
            ->with('success', 'Вишлист успешно создан!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wishlist $wishlist)
    {
        // Проверяем доступ к вишлисту
        if (!$wishlist->canView(Auth::user())) {
            abort(403, 'Доступ запрещен');
        }

        $wishlist->load(['user', 'items', 'editorUsers', 'viewerUsers']);
        
        return view('wishlists.show', compact('wishlist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wishlist $wishlist)
    {
        if (!$wishlist->canEdit(Auth::user())) {
            abort(403, 'Доступ запрещен');
        }

        return view('wishlists.edit', compact('wishlist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        if (!$wishlist->canEdit(Auth::user())) {
            abort(403, 'Доступ запрещен');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'visibility' => 'required|in:public,private,shared',
            'edit_permission' => 'required|in:owner,selected,all',
        ]);

        $wishlist->update($validated);

        return redirect()->route('wishlists.index')
            ->with('success', 'Вишлист успешно обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== Auth::id()) {
            abort(403, 'Доступ запрещен');
        }

        $wishlist->delete();

        return redirect()->route('wishlists.index')
            ->with('success', 'Вишлист успешно удален!');
    }
}