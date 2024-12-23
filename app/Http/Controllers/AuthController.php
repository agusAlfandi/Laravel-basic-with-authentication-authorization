<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthUserRequest;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\RegistrationUser;

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

      return redirect()->route('blog');
    }
    return back()->withErrors([
      'password' => 'The provided password is incorrect.',
    ]);
  }

  public function logout(Request $request)
  {
    if ($request->user()) {
      $request->user()->update(['active' => 0]);
    }

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
  }

  public function register()
  {
    return view('Auth/register');
  }

  public function createUser(RegistrationUser $request)
  {
    $validated = $request->validated();

    $validated['password'] = bcrypt($validated['password']);
    $user = User::create($validated);

    Auth::login($user);

    event(new Registered($user));

    return redirect('/profile');
  }
}
