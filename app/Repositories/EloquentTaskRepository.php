<?php

namespace App\Repositories;

use App\Models\Task;
use App\TaskRepositoryInterface;

class EloquentTaskRepository implements TaskRepositoryInterface
{
    public function getAllTasks()
    {
        return Task::all();
    }

    public function getTaskById($id)
    {
        return Task::find($id);
    }

    public function createTask($data)
    {
        return Task::create($data);
    }

    public function updateTask($id, $data)
    {
        $task = Task::find($id);
        if ($task) {
            $task->update($data);
            return $task;
        }
        return null;
    }

    public function deleteTask($id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete();
            return true;
        }
        return false;
    }

    public function findTaskByUser($userId)
    {
        return Task::where('user_id', $userId)->get();
    }
}