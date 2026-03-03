<?php

namespace App\Providers;
use App\Models\Task;
use App\Policies\TaskPolicy;
use App\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\PaymentGatewayInterface;
use App\Services\RazorpayService;
use App\SmsServiceInterface;
use App\Services\TwilioSmsService;
use App\CacheServiceInterface;
use App\Services\RedisCacheService;
use App\Services\TaskService;

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
    $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    $this->app->bind(PaymentGatewayInterface::class, RazorpayService::class);
    $this->app->bind(SmsServiceInterface::class, TwilioSmsService::class);
    $this->app->bind(CacheServiceInterface::class, RedisCacheService::class);
    $this->app->bind(TaskService::class, function ($app){
            return new TaskService();
      });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
