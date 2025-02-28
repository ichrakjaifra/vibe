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
    // Récupérer les amis où l'utilisateur est user_id
    $friendsAsUser = Auth::user()->friends()->where('friends.status', 'accepted')->get();

    // Récupérer les amis où l'utilisateur est friend_id
    $friendsAsFriend = Auth::user()->friendsOf()->where('friends.status', 'accepted')->get();

    // Fusionner les deux listes
    $friends = $friendsAsUser->merge($friendsAsFriend);

    // Récupérer les demandes d'amis
    $friendRequests = Auth::user()->friendRequests()->get();

    return view('friends.index', compact('friends', 'friendRequests'));
}

    // Envoyer une demande d'ami
    public function store(User $user)
{
    // Vérifier si une demande d'ami existe déjà
    $existingRequest = Friend::where('user_id', Auth::id())
                             ->where('friend_id', $user->id)
                             ->first();

    if (!$existingRequest) {
        Friend::create([
            'user_id' => Auth::id(),
            'friend_id' => $user->id,
            'status' => 'pending',
        ]);
    }

    return redirect()->back()->with('success', 'Demande d\'ami envoyée.');
}

    // Accepter ou refuser une demande d'ami
    public function update(Friend $friend, Request $request)
{
    // Mettre à jour le statut de la demande d'ami
    $friend->update(['status' => $request->status]);

    // Si la demande est acceptée, créer une deuxième entrée pour la relation bidirectionnelle
    if ($request->status === 'accepted') {
        Friend::create([
            'user_id' => $friend->friend_id, // L'ami devient l'utilisateur
            'friend_id' => $friend->user_id, // L'utilisateur devient l'ami
            'status' => 'accepted',
        ]);
    }

    return redirect()->back()->with('success', 'Demande d\'ami mise à jour.');
}

public function destroy(Friend $friend)
{
    // Supprimer la relation d'amitié
    $friend->delete();

    // Supprimer la relation bidirectionnelle (si elle existe)
    Friend::where('user_id', $friend->friend_id)
          ->where('friend_id', $friend->user_id)
          ->delete();

    return redirect()->back()->with('success', 'Ami retiré avec succès.');
}
}