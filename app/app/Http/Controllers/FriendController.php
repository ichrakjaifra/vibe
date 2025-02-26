<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    // Afficher la liste des amis et des demandes
    public function index()
{
    $friends = Auth::user()->acceptedFriends()->get();
    $friendRequests = Auth::user()->friendRequests()->get();

    // Récupérer les objets Friend pour les demandes d'amis
    $friendRequests = Auth::user()->friendRequests()->with('friends')->get();

    return view('friends.index', compact('friends', 'friendRequests'));
}

    // Envoyer une demande d'ami
    public function store(User $user)
    {
        Friend::create([
            'user_id' => Auth::id(),
            'friend_id' => $user->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Demande d\'ami envoyée.');
    }

    // Accepter ou refuser une demande d'ami
    public function update(Friend $friend, Request $request)
{
    $friend->update(['status' => $request->status]);
    return redirect()->back()->with('success', 'Demande d\'ami mise à jour.');
}
}