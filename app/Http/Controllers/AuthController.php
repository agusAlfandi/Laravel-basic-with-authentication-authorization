<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ResetPassword;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ForgotPassword;
use App\Http\Requests\AuthUserRequest;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\RegistrationUser;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

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

    if ($user) {
      $user->update(['active' => 1]);
    }

    event(new Registered($user));
    return redirect('/blog');
  }

  public function forgotPassword(ForgotPassword $request)
  {
    $validated = $request->validated();

    $status = Password::sendResetLink($validated);

    return $status === Password::RESET_LINK_SENT
      ? back()->with('status', __($status))
      : back()->withErrors(['email' => __($status)]);
  }

  public function resetPassword(string $token)
  {
    return view('Auth.reset-password', compact('token'));
  }

  public function updatePassword(ResetPassword $request)
  {
    $validated = $request->validated();

    $status = Password::reset($validated, function (
      User $user,
      string $password
    ) {
      $user
        ->forceFill(['password' => bcrypt($password)])
        ->setRememberToken(Str::random(60));
      $user->save();
      event(new PasswordReset($user));
    });

    return $status === Password::PASSWORD_RESET
      ? redirect()->route('login')->with('status', __($status))
      : back()->withErrors(['email' => __($status)]);
  }
}
