<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\{
    Post,
    Review,
};

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
        'country',
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];


    public function posts() : HasMany
    {
        return $this->hasMany(Post::class, 'id', 'user_id');
    }

    public function reviews() : HasMany
    {
        return $this->hasMany(Review::class,'id', 'user_id');
    }
}
