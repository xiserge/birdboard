<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;

    public function testAnUserCanCreateProject()
	{
		$this->withoutExceptionHandling();

		$this->actingAs(factory(User::class)->create());

		$this->get('/projects/create')->assertStatus(200);

		$attributes = [
		    'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];

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

    public function testGuestsCannotManageProjects()
    {
        $project = factory(Project::class)->create();

        $this->get('/projects/create')->assertRedirect('login');

        $this->post('/projects', $project->toArray())
            ->assertRedirect('login');

        $this->get('/projects')->assertRedirect('login');

        $this->get($project->path())->assertRedirect('login');
    }

    public function testUsersCanViewTheirProject()
    {
        $this->withoutExceptionHandling();

        $this->defaultAuth();
        $project = factory(Project::class)->create([
            'owner_id' => auth()->id(),
        ]);
        $this->get('/projects/'.$project->id)
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    public function testUserCannotSeeProjectsOfOthers()
    {
        $project = factory(Project::class)->create();
        $this->defaultAuth();
        $this->get($project->path())->assertForbidden();
    }

    private function defaultAuth()
    {
        $user = factory(User::class)->create();
        $this->be($user);
    }
}