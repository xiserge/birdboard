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

	/** @test */
    public function can_create_project()
	{
		$this->withoutExceptionHandling();

		$attributes = [
		    'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
		$this->actingAs($this->defaultUser())
            ->post('/projects', $attributes)
            ->assertRedirect('/projects');
		$this->assertDatabaseHas('projects', $attributes);

		$this->get('/projects/')->assertSee($attributes['title']);
	}

	/** @test */
    public function a_title_is_required()
    {
        $attributes = factory(Project::class)->raw([
            'title' => ''
        ]);
        $this->actingAs($this->defaultUser())
            ->post('/projects', $attributes)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_description_is_required()
    {
        $attributes = factory(Project::class)->raw([
            'description' => ''
        ]);
        $this->actingAs($this->defaultUser())
            ->post('/projects', $attributes)
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function owner_is_required()
    {
        $attributes = factory(Project::class)->raw();
        $this->post('/projects', $attributes)
            ->assertRedirect('login');
    }

    /** @test */
    public function an_user_can_view_project()
    {
        $this->withoutExceptionHandling();

        $project = factory(Project::class)->create();
        $this->get('/projects/'.$project->id)
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    private function defaultUser()
    {
        return factory(User::class)->create();
    }
}
