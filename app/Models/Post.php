<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'image',
        'title',
        'slug',
        'content',
        'category_id',
        'user_id',
        'published_at',
    ];
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function readTimeEstimation(): int
    {
        $words = str_word_count(strip_tags($this->content));
        return max(1,ceil($words/100));
    }
    public function postCreatedAt(): string
    {
        return $this->created_at->format('M d, Y');
    }
    public function imageUrl(): string
    {
        return Storage::url($this->image);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function claps()
    {
        return $this->hasMany(Clap::class);
    }
}
