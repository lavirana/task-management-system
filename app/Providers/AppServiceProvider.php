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
use App\TaskRepositoryInterface;
use App\Repositories\EloquentTaskRepository;
use App\Contexts\SessionContext;

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
    $this->app->bind(TaskRepositoryInterface::class, EloquentTaskRepository::class);
    $this->app->bind(TaskService::class, function ($app){
            return new TaskService();
      });
      $this->app->singleton(SessionContext::class, function ($app) {
            return new SessionContext();
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
