<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'role'
    ];

    public function getRoleName()
    {
        return $this->role;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
