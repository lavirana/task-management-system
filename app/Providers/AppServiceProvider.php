<?php

namespace App\Providers;
use App\Models\Task;
use App\Policies\TaskPolicy;
use App\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\PaymentGatewayInterface;
use App\Services\RazorpayService;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $policies = [
        Task::class => TaskPolicy::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->app->bind(
            UserRepositoryInterface::class,
            PaymentGatewayInterface::class,
            UserRepository::class,
            RazorpayService::class
         );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
