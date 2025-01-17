<?php

namespace App\Providers;

use App\Repositories\BlogRepository;
use App\Repositories\ArticleRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\BlogRepositoryInterface;
use App\Repositories\Interfaces\ArticleRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        $this->app->bind(BlogRepositoryInterface::class, BlogRepository::class);

        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
    }
}
