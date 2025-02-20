<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AvatarController extends Controller
{
    
    public function update(UpdateAvatarRequest $request){

      $path = $request->file('avatar')->store('avatars');
      auth()->user()->update(['avatar' => $path]);
      // add or update avatar
      return Redirect::route('profile.edit')->with('status', 'Avatar updated');
    }
}
