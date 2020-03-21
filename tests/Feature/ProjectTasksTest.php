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
        $this->withoutExceptionHandling();

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
