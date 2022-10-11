<?php

namespace App\Http\Controllers;

use App\Http\Services\TodoService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TodoController extends Controller
{
    private TodoService $todoService;

    public function __construct()
    {
        $this->todoService = new TodoService();
    }

    public function showTodos()
    {
        $todos = $this->todoService->getTodos();
        $todos = $this->paginate($todos);

        return $this->responseTodo('Data todo!', $todos, 200);
    }

    public function createTodo(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:3'
        ]);

        $data = [
            'title' => $request->post('title')
        ];

        $dataSaved = [
            'user_id' => auth()->user()->id,
            'title' => $data['title']
        ];

        $id = $this->todoService->addTodo($dataSaved);
        $todo = $this->todoService->getById($id);

        return $this->responseTodo('Berhasil ditambahkan!', $todo, 200);
    }

    public function updateTodo(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:3'
        ]);

        $todoId = $request->post('todo_id');
        $formData = $request->only('title');
        $todo = $this->todoService->getById($todoId);

        if (!$todo) {
            return $this->responseTodo('Data tidak ditemukan!', $todo, 200);
        }

        $this->todoService->updateTodo($todo, $formData);
        $todo = $this->todoService->getById($todoId);

        return $this->responseTodo('Berhasil diperbarui!', $todo, 200);
    }

    public function deleteTodo(Request $request)
    {
        $request->validate([
            'todo_id' => 'required'
        ]);

        $todoId = $request->post('todo_id');
        $todo = $this->todoService->getById($todoId);

        if (!$todo) {
            return $this->responseTodo('Data tidak ditemukan!', null, 200);
        }

        $todo = $this->todoService->delete($todoId);

        return $this->responseTodo('Berhasil dihapus!', null, 200);
    }

    public function responseTodo(string $message, $data, int $status)
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
