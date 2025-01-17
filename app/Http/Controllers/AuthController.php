<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ResetPassword;
use App\Http\Requests\ForgotPassword;
use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\RegistrationUser;
use App\Repositories\AuthRepository;


class AuthController extends Controller
{

  public function __construct(protected AuthRepository $authRepository) {}

  public function index()
  {
    return view('Auth.login');
  }

  public function auth(AuthUserRequest $request)
  {
    $validated = $request->validated();
    return $this->authRepository->login($request, $validated);
  }

  public function logout(Request $request)
  {
    return $this->authRepository->logout($request);
  }

  public function register()
  {
    return view('Auth.register');
  }

  public function createUser(RegistrationUser $request)
  {
    $validated = $request->validated();
    return $this->authRepository->register($validated);
  }

  public function forgotPassword(ForgotPassword $request)
  {
    $validated = $request->validated();
    return $this->authRepository->forgotPaswword($validated);
  }

  public function resetPassword(string $token)
  {
    return view('Auth.reset-password', compact('token'));
  }

  public function updatePassword(ResetPassword $request)
  {
    $validated = $request->validated();
    return $this->authRepository->updatePassword($validated);
  }
}
