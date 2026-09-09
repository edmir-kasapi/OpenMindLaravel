<?php

namespace App\Services\Auth;

use App\Models\User;

class RegistrationService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role_id' => $data['role']
        ]);

        return $user;
    }
}
