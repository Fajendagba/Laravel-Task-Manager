<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_tasks()
    {
        Task::factory()->count(3)->create();

        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertViewHas('tasks');
    }

    public function test_can_create_task()
    {
        $project = Project::factory()->create();

        $response = $this->post(route('tasks.store'), [
            'name' => 'Test Task',
            'project_id' => $project->id
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', [
            'name' => 'Test Task',
            'project_id' => $project->id
        ]);
    }

    public function test_can_update_task()
    {
        $task = Task::factory()->create();

        $response = $this->put(route('tasks.update', $task), [
            'name' => 'Updated Task'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'Updated Task'
        ]);
    }

    public function test_can_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect();
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_can_reorder_tasks()
    {
        $tasks = Task::factory()->count(3)->create();
        $taskIds = $tasks->pluck('id')->reverse()->toArray();

        $response = $this->post(route('tasks.reorder'), [
            'task_ids' => $taskIds
        ]);

        $response->assertJson(['success' => true]);

        foreach ($taskIds as $index => $taskId) {
            $this->assertDatabaseHas('tasks', [
                'id' => $taskId,
                'priority' => $index + 1
            ]);
        }
    }
}