<?php

namespace Tests\Unit;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    function has_path()
    {
        $project = factory(Project::class)->create();
        $this->assertEquals('/projects/'.$project->id, $project->path());
    }
}
