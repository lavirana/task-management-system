<?php

namespace App;

interface CacheServiceInterface
{
    public function store($key, $value);
}
