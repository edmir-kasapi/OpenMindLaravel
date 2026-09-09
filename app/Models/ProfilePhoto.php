<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilePhoto extends Model
{
    protected $fillable = [
        'hashed_name',
        'original_name',
        'extension',
        'size',
        'user_id'
    ];

    public function getSrc()
    {
        return $this->hashed_name;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
