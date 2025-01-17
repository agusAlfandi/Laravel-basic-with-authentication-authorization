<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use Clockwork\Request\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthRepository
{
    public function __construct(protected User $model) {}

    public function login($request, $validated)
    {

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

    public function logout($request)
    {
        if ($request->user()) {
            $request->user()->update(['active' => 0]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function register($validated)
    {
        $validated['password'] = bcrypt($validated['password']);
        $user = $this->model->create($validated);

        Auth::login($user);

        if ($user) {
            $user->update(['active' => 1]);
        }

        event(new Registered($user));
        return redirect('/blog');
    }

    public function forgotPaswword($validated)
    {
        $status = Password::sendResetLink($validated);

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function updatePassword($validated)
    {
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
