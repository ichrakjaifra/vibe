<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
  public function index(Request $request)
{
    $search = $request->input('search');

    // Récupérer les utilisateurs avec le rôle "user" et filtrer par pseudo ou email
    $users = User::where('role', 'user')
                ->when($search, function ($query, $search) {
                    return $query->where('pseudo', 'like', "%$search%")
                                ->orWhere('email', 'like', "%$search%");
                })
                ->get();

    return view('dashboard', compact('users'));
}
}
