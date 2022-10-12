<?php

namespace App\Http\Controllers;

use App\Http\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskController extends Controller
{
    private TaskService $authService;

    public function __construct()
    {
        $this->authService = new TaskService();
    }

    public function showTasks()
    {
        $tasks = $this->authService->getTasks();
        $tasks = $this->paginate($tasks);

        return $this->responseTask('Daftar task!', $tasks, 201);
    }

    public function createTask(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:3',
            'description' => 'required|string|min:3'
        ]);

        $data = [
            'title' => $request->post('title'),
            'description' => $request->post('description')
        ];

        $dataSaved = [
            'user_id' => auth()->user()->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'created_at' => time()
        ];

        $id = $this->authService->addTask($dataSaved);
        $task = $this->authService->getById($id);

        return $this->responseTask('Berhasil ditambahkan!', $task, 201);
    }

    public function updateTask(Request $request)
    {
        $request->validate([
            'title' => 'string|min:3',
            'description' => 'string|min:3'
        ]);

        $taskId = $request->post('task_id');
        $formData = $request->only('title', 'description');
        $task = $this->authService->getById($taskId);

        if (!$task) {
            return $this->responseTask('Data tidak ditemukan!', $task, 401);
        }

        $this->authService->updateTask($task, $formData);
        $task = $this->authService->getById($taskId);

        return $this->responseTask('Berhasil diperbarui!', $task, 201);
    }

    public function deleteTask(Request $request)
    {
        $request->validate([
            'task_id' => 'required'
        ]);

        $taskId = $request->post('task_id');
        $task = $this->authService->getById($taskId);

        if (!$task) {
            return $this->responseTask('Data tidak ditemukan!', null, 401);
        }

        $task = $this->authService->delete($taskId);

        return $this->responseTask('Berhasil dihapus!', null, 201);
    }

    public function responseTask(string $message, $data, int $status)
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
