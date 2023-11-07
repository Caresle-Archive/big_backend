<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\{
    Category,
    Review,
    User,
};

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'category_id',
        'review_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'id', 'category_id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function reviews() : HasMany
    {
        return $this->hasMany(Review::class, 'id', 'review_id');
    }
}
