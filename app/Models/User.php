<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'provider_id',
        'avatar',
        'email_verified_at',
        'description',
        'github_url', 
    ];

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

    # Módulo de Posts
    public function comments(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function posts(){
        $this->hasMany(Post::class);
    }

    public function reaccions(){
        $this->hasMany(Reaccion::class);
    }

    public function reposts()
    {
        return $this->hasMany(Repost::class);
    }

    # Módulo de Seguidores
    public function following(){
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function followers(){
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function isFollowing(User $user){
        return $this->following()->where('follower_id', $user->id)->exists();
    }

    public function isFollower(User $user){
        return $this->followers()->where('user_id', $user->id)->exists();
    }

    # GRupos
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user')->withTimestamps();
    }
}
