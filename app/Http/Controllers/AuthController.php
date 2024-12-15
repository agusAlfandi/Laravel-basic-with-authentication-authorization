<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthUserRequest;

class AuthController extends Controller
{
  public function index()
  {
    return view('Auth/login');
  }

  public function auth(AuthUserRequest $request)
  {
    $validated = $request->validated();

    if (Auth::attempt($validated)) {
      $request->session()->regenerate();

      if ($request->user()) {
        $request->user()->update(['active' => 1]);
      }

      return redirect('/blog');
    }
  }

  public function logout(Request $request)
  {
    if ($request->user()) {
      $request->user()->update(['active' => 0]);
    }

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
  }
}
