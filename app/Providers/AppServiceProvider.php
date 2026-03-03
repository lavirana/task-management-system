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
            SmsServiceInterface::class,
            CacheServiceInterface::class,
            UserRepository::class,
            RazorpayService::class,
            TwilioSmsService::class,
            RedisCacheService::class,
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
