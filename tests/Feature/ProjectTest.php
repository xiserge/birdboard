<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;

    public function testCanCreateProject()
	{
		$this->withoutExceptionHandling();

		$attributes = [
		    'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
		$this->defaultAuth();
		$this->post('/projects', $attributes)
            ->assertRedirect('/projects');
		$this->assertDatabaseHas('projects', $attributes);

		$this->get('/projects/')->assertSee($attributes['title']);
	}

    public function testTitleRequired()
    {
        $attributes = factory(Project::class)->raw([
            'title' => ''
        ]);
        $this->defaultAuth();
        $this->post('/projects', $attributes)
            ->assertSessionHasErrors('title');
    }

    public function testDescriptionRequired()
    {
        $attributes = factory(Project::class)->raw([
            'description' => ''
        ]);
        $this->defaultAuth();
        $this->post('/projects', $attributes)
            ->assertSessionHasErrors('description');
    }

    public function testOwnerRequired()
    {
        $attributes = factory(Project::class)->raw();
        $this->post('/projects', $attributes)
            ->assertRedirect('login');
    }

    public function testUserCanViewProject()
    {
        $this->withoutExceptionHandling();

        $project = factory(Project::class)->create();
        $this->get('/projects/'.$project->id)
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    private function defaultAuth()
    {
        $this->actingAs(factory(User::class)->create());
    }
}
