<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

  //   public function sentFriendRequests() {
  //     return $this->hasMany(Friend::class, 'user_id');
  // }
  
  // public function receivedFriendRequests() {
  //     return $this->hasMany(Friend::class, 'friend_id');
  // }
  
  // public function friends() {
  //     return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
  //                 ->wherePivot('status', 'accepted')
  //                 ->union(
  //                     $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
  //                          ->wherePivot('status', 'accepted')
  //                 );
  // }

  // Relation pour les amis
  public function friends()
  {
      return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
                  ->withPivot('status');
  }

  // Relation pour les demandes d'amis reçues
  public function friendRequests()
{
    return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
                ->withPivot('id', 'status') // Ajoutez 'id' pour récupérer l'ID de la table friends
                ->wherePivot('status', 'pending');
}

  // Relation pour les amis acceptés
  public function acceptedFriends()
  {
      return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
                  ->withPivot('status')
                  ->wherePivot('status', 'accepted');
  }
  
}
