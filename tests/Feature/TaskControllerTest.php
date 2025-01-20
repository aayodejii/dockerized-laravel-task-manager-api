<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    private function authenticateUser()
    {
        Sanctum::actingAs($this->user);
    }

    public function test_unauthenticated_user_cannot_access_tasks()
    {
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(401);
    }


    public function test_can_create_task()
    {
        $this->authenticateUser();
        $taskData = [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => 'pending',
            'due_date' => '2024-02-01'
        ];
    
        $response = $this->postJson('/api/tasks', $taskData);
    
        $response->assertStatus(201);
        $responseData = json_decode($response->getContent(), true);
        
        $this->assertEquals('Task created successfully', $responseData['message']);
        $this->assertEquals('Test Task', $responseData['data']['title']);
        $this->assertEquals('Test Description', $responseData['data']['description']);
        $this->assertEquals($this->user->id, $responseData['data']['user_id']);
    }

    public function test_can_show_task()
    {
        $this->authenticateUser();
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => ['id', 'title', 'description', 'status', 'due_date', 'user_id']
                ]);
    }

    public function test_cannot_show_task_of_other_user()
    {
        $this->authenticateUser();
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(404);
    }

    public function test_cannot_update_task_of_other_user()
    {
        $this->authenticateUser();
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $otherUser->id]);

        $updateData = [
            'title' => 'Updated Task',
            'status' => 'completed'
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(404);
    }

    public function test_can_get_all_tasks()
    {
        $this->authenticateUser();
        Task::factory()->count(3)->create(['user_id' => $this->user->id]);
        // Create tasks for another user to ensure they're not returned
        Task::factory()->count(2)->create();
    
        $response = $this->getJson('/api/tasks');
    
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'data' => [
                             '*' => [
                                 'id', 
                                 'title', 
                                 'description', 
                                 'status', 
                                 'due_date', 
                                 'user_id'
                             ]
                         ]
                     ]
                 ]);
        
        $responseData = json_decode($response->getContent(), true);
        $this->assertCount(3, $responseData['data']['data']);
    }
    
    public function test_can_update_task()
    {
        $this->authenticateUser();
        $task = Task::factory()->create(['user_id' => $this->user->id]);
    
        $updateData = [
            'title' => 'Updated Task',
            'status' => 'completed'
        ];
    
        $response = $this->putJson("/api/tasks/{$task->id}", $updateData);
    
        $response->assertStatus(200);
        
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Task updated successfully', $responseData['message']);
        $this->assertEquals('Updated Task', $responseData['data']['title']);
        $this->assertEquals('completed', $responseData['data']['status']);
        $this->assertEquals($this->user->id, $responseData['data']['user_id']);
    }

    public function test_can_delete_task()
    {
        $this->authenticateUser();
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
                ->assertJsonFragment(['message' => 'Task deleted successfully']);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_cannot_delete_task_of_other_user()
    {
        $this->authenticateUser();
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(404);
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }
}