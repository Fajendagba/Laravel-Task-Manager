<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $projects = [
            'Personal' => ['Learn Laravel', 'Exercise daily', 'Read 2 books this month'],
            'Work' => ['Complete API documentation', 'Review pull requests', 'Deploy to production'],
            'Side Project' => ['Design landing page', 'Set up CI/CD pipeline', 'Write unit tests']
        ];

        foreach ($projects as $projectName => $tasks) {
            $project = Project::create(['name' => $projectName]);

            foreach ($tasks as $index => $taskName) {
                Task::create([
                    'name' => $taskName,
                    'priority' => $index + 1,
                    'project_id' => $project->id
                ]);
            }
        }

        $generalTasks = [
            'Call mom',
            'Buy groceries',
            'Schedule dentist appointment'
        ];

        foreach ($generalTasks as $index => $taskName) {
            Task::create([
                'name' => $taskName,
                'priority' => $index + 1,
                'project_id' => null
            ]);
        }
    }
}
