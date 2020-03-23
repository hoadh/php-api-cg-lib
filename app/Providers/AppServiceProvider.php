<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\Contracts\UserRepositoryInterface::class,
            \App\Repositories\Eloquent\UserEloquentRepository::class
        );
        $this->app->singleton(
            \App\Services\UserServiceInterface::class,
            \App\Services\Impl\UserService::class
        );

        $this->app->singleton(
            \App\Repositories\Contracts\LibraryRepositoryInterface::class,
            \App\Repositories\Eloquent\LibraryEloquentRepository::class
        );

        $this->app->singleton(
            \App\Services\LibraryServiceInterface::class,
            \App\Services\Impl\LibraryService::class
        );

        $this->app->singleton(
            \App\Repositories\Contracts\CategoryRepositoryInterface::class,
            \App\Repositories\Eloquent\CategoryEloquentRepository::class
        );

        $this->app->singleton(
            \App\Services\CategoryServiceInterface::class,
            \App\Services\Impl\CategoryService::class
        );

        $this->app->singleton(
            \App\Repositories\Contracts\BookRepositoryInterface::class,
            \App\Repositories\Eloquent\BookEloquentRepository::class
        );

        $this->app->singleton(
            \App\Services\BookServiceInterface::class,
            \App\Services\Impl\BookService::class
        );

        $this->app->singleton(
            \App\Repositories\Contracts\BorrowRepositoryInterface::class,
            \App\Repositories\Eloquent\BorrowEloquentRepository::class
        );

        $this->app->singleton(
            \App\Services\BorrowServiceInterface::class,
            \App\Services\Impl\BorrowService::class
        );

        $this->app->singleton(
            \App\Services\CustomerServiceInterface::class,
            \App\Services\Impl\CustomerService::class
        );

        $this->app->singleton(
            \App\Repositories\Contracts\CustomerRepositoryInterface::class,
            \App\Repositories\Eloquent\CustomerEloquentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
