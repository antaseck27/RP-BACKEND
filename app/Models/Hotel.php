<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'email',
        'phone',
        'price_per_night',
        'currency',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
