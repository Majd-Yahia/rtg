<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'language',
        'avatar',
    ];

    protected $casts = [
        'avatar' => 'json'
    ];

    public function user()
    {
        $this->hasOne(User::class);
    }
}
