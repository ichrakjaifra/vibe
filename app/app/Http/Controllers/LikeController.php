<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // Ajouter ou supprimer un like
    public function toggleLike(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        $user = Auth::user();
        $postId = $request->post_id;

        // Vérifier si l'utilisateur a déjà liké ce post
        $like = Like::where('user_id', $user->id)
                    ->where('post_id', $postId)
                    ->first();

        if ($like) {
            // Supprimer le like si l'utilisateur a déjà liké
            $like->delete();
            $message = 'Like retiré.';
        } else {
            // Ajouter un like si l'utilisateur n'a pas encore liké
            Like::create([
                'user_id' => $user->id,
                'post_id' => $postId,
            ]);
            $message = 'Post liké.';
        }

        // Retourner le nombre total de likes pour ce post
        $likesCount = Like::where('post_id', $postId)->count();

        return response()->json([
            'success' => true,
            'message' => $message,
            'likes_count' => $likesCount,
        ]);
    }
}