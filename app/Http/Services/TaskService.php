<?php

namespace App\Http\Services;

use App\Http\Repositories\TaskRepository;

class TaskService
{
	private TaskRepository $taskRepository;

	public function __construct()
	{
		$this->taskRepository = new TaskRepository();
	}

	public function getTasks()
	{
		$tasks = $this->taskRepository->getAll();
		return $tasks;
	}

	public function addTask(array $data)
	{
		$taskId = $this->taskRepository->create($data);
		return $taskId;
	}

	public function getById(string $taskId)
	{
		$task = $this->taskRepository->getById($taskId);
		return $task;
	}

	public function updateTask(array $editTask, array $formData)
	{
		if (isset($formData['title'])) {
			$editTask['title'] = $formData['title'];
		}

		if (isset($formData['description'])) {
			$editTask['description'] = $formData['description'];
		}

		$id = $this->taskRepository->save($editTask);
		return $id;
	}

	public function delete(string $taskId)
	{
		$task = $this->taskRepository->delete($taskId);
		return $task;
	}
}
