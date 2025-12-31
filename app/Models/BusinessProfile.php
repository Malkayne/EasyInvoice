<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessProfile extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'email',
        'phone',
        'address',
        'currency',
        'tax_rate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
