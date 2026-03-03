<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CacheServiceInterface;

class CacheController extends Controller
{
    private $cacheService;
    public function __construct(CacheServiceInterface $cacheService)
     {
         $this->cacheService = $cacheService;
     }
     public function save(){
        return $this->cacheService->store('name', 'Task Management System');
     }
}
