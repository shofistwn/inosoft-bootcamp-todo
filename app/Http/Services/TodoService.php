<?php

namespace App\Http\Services;

use App\Http\Repositories\TodoRepository;

class TodoService
{
	private TodoRepository $todoRepository;

	public function __construct()
	{
		$this->todoRepository = new TodoRepository();
	}

	public function getTodos()
	{
		$todos = $this->todoRepository->getAll();
		return $todos;
	}

	public function addTodo(array $data)
	{
		$todoId = $this->todoRepository->create($data);
		return $todoId;
	}

	public function getById(string $todoId)
	{
		$todo = $this->todoRepository->getById($todoId);
		return $todo;
	}

	public function updateTodo(array $editTodo, array $formData)
	{
		if (isset($formData['title'])) {
			$editTodo['title'] = $formData['title'];
		}

		$id = $this->todoRepository->save($editTodo);
		return $id;
	}

	public function delete(string $todoId)
	{
		$todo = $this->todoRepository->delete($todoId);
		return $todo;
	}
}
