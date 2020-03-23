<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestsCannotAddTask()
    {
        $project = factory(Project::class)->create();
        $this->post($project->path().'/tasks', ['body' => 'Test task'])->assertRedirect('login');
    }

    function testOnlyTheOwnerOfProjectCanAddTasks()
    {
        $this->signIn();
        $project = factory(Project::class)->create();
        $this->post($project->path().'/tasks', ['body' => 'Test task'])->assertForbidden();

        $this->assertDatabaseMissing('tasks', [
            'Test task',
        ]);
    }

    public function testProjectCanHaveTasks()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );


        $this->post($project->path().'/tasks', [
            'body' => 'Test body',
        ]);

        $this->get($project->path())
            ->assertSee('Test body');
    }

    function testTaskCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $task = factory(Task::class)->create();

        $this->patch($task->project->path().'/tasks/'.$task->id, [
            'body' => 'Updated body',
            'completed' => 1
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'Updated body',
            'completed' => 1,
        ]);
    }


    public function testTaskRequaredABody()
    {
        $this->signIn();
        $attributes = factory(Task::class)->raw([
            'body' => ''
        ]);
        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $this->post($project->path().'/tasks', $attributes)
            ->assertSessionHasErrors('body');
    }
}
