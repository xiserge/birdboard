<?php

namespace Tests\Unit;

use App\Project;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    function testTaskBelongsToProject() {
        $task = factory(Task::class)->create();
        $this->assertInstanceOf(Project::class, $task->project);
    }
}
