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

    /**
     * Untuk mengambil semua todos
     */
    public function getAll()
    {
        $todos = $this->todos->get([]);
        return $todos;
    }

    /**
     * Untuk mendapatkan task bedasarkan id
     *  */
    public function getById(string $id)
    {
        $todo = $this->todos->find(['_id' => $id]);
        return $todo;
    }

    /**
     * Untuk membuat task
     */
    public function create(array $data)
    {
        $dataSaved = [
            'title' => $data['title'],
            'description' => $data['description'],
            'assigned' => null,
            'subtodos' => [],
            'created_at' => time()
        ];

        $id = $this->todos->save($dataSaved);
        return $id;
    }

    /**
     * Untuk menyimpan task baik untuk membuat baru atau menyimpan dengan struktur bson secara bebas
     *  */
    public function save(array $editedData)
    {
        $id = $this->todos->save($editedData);
        return $id;
    }

    /**
     * Untuk menghapus task atau subtask
     *  */
    public function delete(string $id)
    {
        $todo = $this->todos->deleteQuery(['_id' => $id]);
        return $todo;
    }
}
