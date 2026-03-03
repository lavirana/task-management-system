<?php

namespace App\Services;
use App\Models\Task;

class TaskService {
     public function getTaskById($id){
         return Task::find($id);
     }
}