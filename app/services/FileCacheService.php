<?php

namespace App\Services;

class FileCacheService implements FileCacheService {
    public function store($key, $value){
        file_put_contents(storage_path($key), $value);
        return "Stored in File";
    }
}