<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Afficher tous les posts
    public function index()
{
    $posts = Post::with('user', 'likes', 'comments.user')->latest()->get();
    return view('posts.index', compact('posts'));
}

    // Afficher le formulaire de création de post
    public function create()
    {
        return view('posts.create');
    }

    // Enregistrer un nouveau post
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:500',
            'image' => 'nullable|image|max:2048',
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post créé avec succès.');
    }

    // Supprimer un post
    public function destroy(Post $post)
    {
        if ($post->user_id == Auth::id()) {
            $post->delete();
            return redirect()->route('posts.index')->with('success', 'Post supprimé avec succès.');
        }

        return redirect()->route('posts.index')->with('error', 'Vous n\'êtes pas autorisé à supprimer ce post.');
    }

    // Afficher le formulaire de modification de post
public function edit(Post $post)
{
    if ($post->user_id != Auth::id()) {
        return redirect()->route('posts.index')->with('error', 'Vous n\'êtes pas autorisé à modifier ce post.');
    }

    return view('posts.edit', compact('post'));
}

// Mettre à jour un post
public function update(Request $request, Post $post)
{
    if ($post->user_id != Auth::id()) {
        return redirect()->route('posts.index')->with('error', 'Vous n\'êtes pas autorisé à modifier ce post.');
    }

    $request->validate([
        'content' => 'required|string|max:500',
        'image' => 'nullable|image|max:2048',
    ]);

    $post->content = $request->content;

    if ($request->hasFile('image')) {
        $post->image = $request->file('image')->store('posts', 'public');
    }

    $post->save();

    return redirect()->route('posts.index')->with('success', 'Post modifié avec succès.');
}
}
