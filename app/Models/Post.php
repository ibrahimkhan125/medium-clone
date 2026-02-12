<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model implements HasMedia
{
    //
    use HasFactory;
    use InteractsWithMedia;
    use HasSlug;
    protected $fillable = [
        'image',
        'title',
        'slug',
        'content',
        'category_id',
        'user_id',
        'published_at',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function readTimeEstimation(): int
    {
        $words = str_word_count(strip_tags($this->content));
        return max(1, ceil($words / 100));
    }
    public function postCreatedAt(): string
    {
        return $this->created_at->format('M d, Y');
    }
    public function imageUrl($preview = ''): string
    {
        // return Storage::url($this->image);
        // if(!$this->getFirstMedia()){
        //     return Storage::url($this->image);
        // }
        $media = $this->getFirstMedia();
        if($media){
            if($media?->hasGeneratedConversion($preview)){
                return $media->getUrl($preview);
            }
            return $media?->getUrl();
        }
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
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->width(400);
        $this
            ->addMediaConversion('large')
            ->width(1200);
    }
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('default')
            ->singleFile();
    }
}
