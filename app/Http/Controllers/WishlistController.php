<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlists = Wishlist::forUser(Auth::user())
            ->with(['user', 'editorUsers', 'viewerUsers'])
            ->withProgress()
            ->active()
            ->ordered()
            ->get();
        return view('wishlists.index', compact('wishlists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('wishlists.create', compact('users'));
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
            'edit_permission' => 'required|in:owner,selected',
            'viewer_users' => 'nullable|array',
            'viewer_users.*' => 'exists:users,id',
            'editor_users' => 'nullable|array',
            'editor_users.*' => 'exists:users,id',
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

        if ($validated['visibility'] === 'shared' && isset($validated['viewer_users'])) {
            $wishlist->viewerUsers()->sync($validated['viewer_users']);
        }

        if ($validated['edit_permission'] === 'selected' && isset($validated['editor_users'])) {
            $wishlist->editorUsers()->sync($validated['editor_users']);
        }

        return redirect()->route('wishlists.index')
            ->with('success', 'Вишлист успешно создан!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wishlist $wishlist)
    {
        if (! Gate::allows('view', $wishlist)) {
            abort(403);
        }

        $wishlist->load(['user', 'items', 'editorUsers', 'viewerUsers']);

        return view('wishlists.show', compact('wishlist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wishlist $wishlist)
    {
        if (! Gate::allows('update', $wishlist)) {
            abort(403);
        }

        $users = User::where('id', '!=', Auth::id())->get();
        $wishlist->load(['viewerUsers', 'editorUsers']);

        return view('wishlists.edit', compact('wishlist', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        if (! Gate::allows('update', $wishlist)) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'visibility' => 'required|in:public,private,shared',
            'edit_permission' => 'required|in:owner,selected,all',
            'viewer_users' => 'nullable|array',
            'viewer_users.*' => 'exists:users,id',
            'editor_users' => 'nullable|array',
            'editor_users.*' => 'exists:users,id',
        ]);

        $wishlist->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'visibility' => $validated['visibility'],
            'edit_permission' => $validated['edit_permission'],
        ]);

        // Обновляем пользователей для просмотра
        if ($validated['visibility'] === 'shared') {
            $wishlist->viewerUsers()->sync($validated['viewer_users'] ?? []);
        } else {
            $wishlist->viewerUsers()->detach();
        }

        // Обновляем пользователей для редактирования
        if ($validated['edit_permission'] === 'selected') {
            $wishlist->editorUsers()->sync($validated['editor_users'] ?? []);
        } else {
            $wishlist->editorUsers()->detach();
        }

        return redirect()->route('wishlists.show', $wishlist)
            ->with('success', 'Вишлист успешно обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wishlist $wishlist)
    {
        if (! Gate::allows('delete', $wishlist)) {
            abort(403);
        }

        $wishlist->delete();

        return redirect()->route('wishlists.index')
            ->with('success', 'Вишлист успешно удален!');
    }
}
