<?php

namespace Database\Seeders;

use App\Http\Repositories\TaskRepository;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
	private TaskRepository $taskRepository;

	public function __construct()
	{
		$this->taskRepository = new TaskRepository();
	}
    
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $this->taskRepository->create([
                'user_id' => null,
                'title' => 'Task ' . $i,
                'description' => 'Deskripsi task ' . $i,
                'created_at' => Carbon::now()->timestamp
            ]);
        }
    }
}
