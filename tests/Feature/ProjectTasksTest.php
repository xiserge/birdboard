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

    function testOnlyOwnerOfProjectCanAddTasks()
    {
        $this->signIn();
        $project = factory(Project::class)->create();
        $this->post($project->path().'/tasks', ['body' => 'Test task'])->assertForbidden();

        $this->assertDatabaseMissing('tasks', [
            'Test task',
        ]);
    }

    public function testOnlyOwnerCanChangeTasks()
    {
        $this->signIn();
        $project = factory(Project::class)->create();
        $task = $project->addTask('Test task');
        $this->patch($task->path(), ['body' => 'Updated task'])->assertForbidden();

        $this->assertDatabaseMissing('tasks', [
            'Updated task',
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

        $project = factory(Project::class)->create([
            'owner_id' => auth()->id()
        ]);
        $task = $project->addTask('Test task');

        $this->patch($task->path(), [
            'body' => 'Updated body',
            'completed' => 1
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'Updated body',
            'completed' => 1,
        ]);

        $this->assertDatabaseMissing('tasks', [
            'body' => 'Test task',
            'completed' => 1,
        ]);
    }

    public function testTaskRequiredABody()
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
