<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class UserController extends Controller
{
    use Notifiable;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.user.home');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('pages.user.profile');
    }

}
