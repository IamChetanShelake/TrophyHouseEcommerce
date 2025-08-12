<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Order;
use App\Models\WishlistItem;
use App\Models\Message;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    protected $appends = ['profile_img'];

public function getProfileImgAttribute()
{
    if ($this->attributes['profile_img']) {
        return asset('profile_images/' . $this->attributes['profile_img']);
    }
    return null;
}

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

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
            'password' => 'hashed',
        ];
    }
    public function customizationRequests()
    {
        return $this->hasMany(CustomizationRequest::class, 'user_id')
                    ->union($this->hasMany(CustomizationRequest::class, 'designer_id'))
                    ->orderBy('created_at', 'desc');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function wishlistItems()
    {
        return $this->hasMany(WishlistItem::class); //one user can have many wishlist items
    }
    
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
}
