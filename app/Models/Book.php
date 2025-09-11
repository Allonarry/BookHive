<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'published_year',
        'genre_id',
        'description',
        'trade_option',
        'user_id',
        'image'
    ];

    protected $attributes = [
        'status' => 'active'
    ];

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->with('user', 'likes')->latest();
    }

    public function averageRating()
    {
        return $this->comments()->avg('rating') ?? 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->comments()->whereNotNull('rating')->count();
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'book_favorites')->withTimestamps();
    }

}