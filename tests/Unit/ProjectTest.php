<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    function testItHasPath()
    {
        $project = factory(Project::class)->create();
        $this->assertEquals('/projects/'.$project->id, $project->path());
    }

    function testItBelongsToUser()
    {
        $project = factory(Project::class)->create();
        $this->assertInstanceOf(User::class, $project->owner);
    }
}
