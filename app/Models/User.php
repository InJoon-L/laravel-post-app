<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 외래키 정의 1대n 1쪽에서 정의시 복수 user->posts 접근 가능
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function viewd_posts()
    {
        return $this->belongsToMany(Post::class);
        // return $this->belongsToMany(Post::class, 'post_user', 'user_id', 'post_id', 'id', 'id', 'posts');

    }
}
