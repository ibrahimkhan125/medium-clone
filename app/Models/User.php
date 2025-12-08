<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Str;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'image',
        'bio',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function imageUrl()
    {
        $media = $this->getFirstMedia('avatar');
        if(!$media){
            return 'https://ui-avatars.com/api/?name=' . $this->name . '&color=7F9CF5&background=EBF4FF';
        }   
        if($media->hasGeneratedConversion('avatar')){
            return $media->getUrl('avatar');
        }
        return $media->getUrl();
        // return $this->image ? Storage::url($this->image) : 'https://ui-avatars.com/api/?name=' . $this->name . '&color=7F9CF5&background=EBF4FF';
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function following(){
        return $this->belongsToMany(User::class, 'followers','follower_id', 'user_id');
    }
    public function followers(){
        return $this->belongsToMany(User::class, 'followers','user_id', 'follower_id');
    }
    public function isFollowedBy(?User $user): bool
    {
        if(!$user){
            return false;
        }
        return $this->followers()->where('follower_id', $user->id)->exists();
    }
    public static function generateUniqueUsername(string $name): string
    {
        $base = Str::slug($name);
        $username = $base;
        $counter = 1;

        // Keep checking until we find a unique username
        while (User::where('username', $username)->exists()) {
            $username = "{$base}-{$counter}";
            $counter++;
        }

        return $username;
    }
    public function hasClappedThisPost(Post $post)
    {
        return $post->claps()->where('user_id', $this->id)->exists();
    }
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('avatar')
            ->width(100)
            ->crop(128, 128);
    }
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile();
    }
}
