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

	/**
	 * NOTE: untuk mengambil semua tasks di collection task
	 */
	public function getTasks()
	{
		$tasks = $this->todoRepository->getAll();
		return $tasks;
	}

	/**
	 * NOTE: menambahkan task
	 */
	public function addTask(array $data)
	{
		$taskId = $this->todoRepository->create($data);
		return $taskId;
	}

	/**
	 * NOTE: UNTUK mengambil data task
	 */
	public function getById(string $todoId)
	{
		$todo = $this->todoRepository->getById($todoId);
		return $todo;
	}

	/**
	 * NOTE: untuk update task
	 */
	public function updateTask(array $editTask, array $formData)
	{
		if (isset($formData['title'])) {
			$editTask['title'] = $formData['title'];
		}

		if (isset($formData['description'])) {
			$editTask['description'] = $formData['description'];
		}

		$id = $this->todoRepository->save($editTask);
		return $id;
	}

	/**
	 * NOTE: UNTUK menghapus data task
	 */
	public function delete(string $taskId)
	{
		$todo = $this->todoRepository->delete($taskId);
		return $todo;
	}

	/**
	 * NOTE: untuk assign task
	 */
	public function assignTask(array $editTask, array $formData)
	{
		if (isset($formData['assigned'])) {
			$editTask['assigned'] = $formData['assigned'];
		}

		$id = $this->todoRepository->save($editTask);
		return $id;
	}

	/**
	 * NOTE: untuk unassign task
	 */
	public function unassignTask(array $editTask)
	{
		$editTask['assigned'] = null;

		$id = $this->todoRepository->save($editTask);
		return $id;
	}

	/**
	 * NOTE: untuk membuat subtask
	 */
	public function createSubtask(array $editTask, array $formData)
	{
		if (isset($formData)) {
			$editTask['subtasks'] = $formData;
		}

		$id = $this->todoRepository->save($editTask);
		return $id;
	}

	/**
	 * NOTE: untuk menghapus subtask
	 */
	public function deleteSubtask(array $editTask, array $formData)
	{
		if (isset($formData)) {
			$editTask['subtasks'] = $formData;
		}

		$id = $this->todoRepository->save($editTask);
		return $id;
	}
}
