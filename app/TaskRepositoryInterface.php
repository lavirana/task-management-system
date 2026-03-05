<?php

namespace App;

interface TaskRepositoryInterface
{
    public function getAllTasks();

    public function getTaskById($id);

    public function createTask($data);

    public function updateTask($id, $data);

    public function deleteTask($id);

    public function findTaskByUser($userId);
}
