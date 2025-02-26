<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // Ajouter un like à un post
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        Like::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
        ]);

        return redirect()->back()->with('success', 'Post liké.');
    }
}
