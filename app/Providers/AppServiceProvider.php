<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use App\Services\PostService;
use App\Services\UserService;
use App\Services\ImageService;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\PostServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\Contracts\ImageServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ImageServiceInterface::class, function () {
            return new ImageService(new Image());
        });

        $this->app->bind(PostServiceInterface::class, function () {
            return new PostService(new Post());
        });

        $this->app->bind(UserServiceInterface::class, function () {
            return new UserService(new User());
        });
    }
}
