<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Phone;
use Illuminate\Http\Request;

class UserController extends Controller
{
  function index()
  {
    // $users = User::with('phone')->get();
    $users = User::with('image')->get();
    // return $users;
    return view('Auth/users', compact('users'));
  }

  function phones()
  {
    // $phones = Phone::all();
    $phones = Phone::with('user')->get();
    return $phones;
    // return $this->belongsTo(User::class, 'user_id');
  }
}
