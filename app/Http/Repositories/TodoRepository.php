<?php

namespace App\Http\Repositories;

use App\Helpers\MongoModel;

class TodoRepository
{
    private MongoModel $todos;

    public function __construct()
    {
        $this->todos = new MongoModel('todos');
    }

    public function getAll()
    {
        $todos = $this->todos->get([]);
        return $todos;
    }

    public function getById(string $id)
    {
        $todo = $this->todos->find(['_id' => $id]);
        return $todo;
    }

    public function create(array $data)
    {
        $dataSaved = [
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'created_at' => time()
        ];

        $id = $this->todos->save($dataSaved);
        return $id;
    }

    public function save(array $editedData)
    {
        $id = $this->todos->save($editedData);
        return $id;
    }

    public function delete(string $id)
    {
        $todo = $this->todos->deleteQuery(['_id' => $id]);
        return $todo;
    }
}
