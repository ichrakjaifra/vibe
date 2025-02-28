<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
//   public function index(Request $request)
// {
//     $search = $request->input('search');
//     $users = User::where('role', 'user')
//                 ->when($search, function ($query, $search) {
//                     return $query->where('pseudo', 'like', "%$search%")
//                                 ->orWhere('email', 'like', "%$search%");
//                 })
//                 ->get();

//     return view('dashboard', compact('users'));
// }
public function index()
{
    // Récupérer tous les utilisateurs avec le rôle "user" (sauf l'utilisateur connecté)
    $users = User::where('id', '!=', Auth::id())
                 ->where('role', 'user') // Filtrer par rôle "user"
                 ->get();

    // Récupérer les demandes d'amis envoyées par l'utilisateur connecté
    $sentRequests = Auth::user()->friends()->where('friends.status', 'pending')->pluck('friend_id');

    // Récupérer les demandes d'amis reçues par l'utilisateur connecté
    $receivedRequests = Auth::user()->friendRequests()->where('friends.status', 'pending')->pluck('user_id');

    // Récupérer les amis acceptés
    $acceptedFriends = Auth::user()->acceptedFriends()->pluck('friend_id');

    return view('dashboard', compact('users', 'sentRequests', 'receivedRequests', 'acceptedFriends'));
}
}
