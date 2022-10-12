<?php

namespace App\Http\Repositories;

use App\Helpers\MongoModel;

class TaskRepository
{
    private MongoModel $tasks;

    public function __construct()
    {
        $this->tasks = new MongoModel('tasks');
    }

    public function getAll()
    {
        $tasks = $this->tasks->get([]);
        return $tasks;
    }

    public function getById(string $id)
    {
        $task = $this->tasks->find(['_id' => $id]);
        return $task;
    }

    public function create(array $data)
    {
        $dataSaved = [
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'created_at' => $data['created_at']
        ];

        $id = $this->tasks->save($dataSaved);
        return $id;
    }

    public function save(array $editedData)
    {
        $id = $this->tasks->save($editedData);
        return $id;
    }

    public function delete(string $id)
    {
        $task = $this->tasks->deleteQuery(['_id' => $id]);
        return $task;
    }
}
