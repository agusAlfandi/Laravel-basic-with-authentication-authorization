<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    Gate::define('manage-blog', function (User $user, Blog $blog) {
      return $user->id === $blog->author_id
        ? Response::allow()
        : Response::deny('You are not the author of this blog');
    });
  }
}
