<?php

namespace Tests\Feature;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_user_can_read_all_the_tasks()
    {
       $task = Task::factory()->create();
        $response = $this->get('/tasks');

        $response->assertSee($task->title);
    }
    
    public function test_a_user_can_read_single_task()
    {
    //Given we have task in the database
    $task = Task::factory()->create();
    //When user visit the task's URI
    $response = $this->get('/tasks/'.$task->id);
    //He can see the task details
    $response->assertSee($task->title)
        ->assertSee($task->description);
    }

    public function test_authenticated_users_can_create_a_new_task()
    {
    //Given we have an authenticated user
    $this->actingAs(User::factory()->create());
    //And a task object
    $task = Task::factory()->make();
    //When user submits post request to create task endpoint
    $this->post('/tasks/create',$task->toArray());
    //It gets stored in the database
    $this->assertEquals(1,Task::all()->count());
    }




}
