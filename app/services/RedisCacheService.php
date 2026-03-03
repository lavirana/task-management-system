<?php

use Illuminate\Support\Facades\Redis;

class RedisCacheService implements CacheServiceInterface
{
    public function store($key, $value)
    {
        Redis::set($key, $value);
        return "Stored in Redis";
    }
}