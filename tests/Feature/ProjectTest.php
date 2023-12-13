<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create_a_project()
    {
        $projectData = [
            'title' => 'Test Test Project',
            'description' => 'This is a test project description.',
            'team_size' => 5,
            'trimester' => 3,
            'year' => 2025,
            'coordinator_name' => 'John Doe',
            'coordinator_email' => 'john.doe@example.com',
            'complexity' => 'hard',
            'inpID' => 5, // Assuming a user with ID 1 exists
        ];

        $response = $this->post(route('project.store'), $projectData);

        $response->assertStatus(302);
    }

    /** @test */
    public function project_with_invalid_data()
    {
        $invalidData = [
            'title' => '',
            'description' => '',
            'team_size' => 5,
            'trimester' => 3,
            'year' => 2025,
            'coordinator_name' => 'John Doe',
            'coordinator_email' => 'john.doe@example.com',
            'complexity' => 'hard',
            'inpID' => 5, // Assuming a user with ID 1 exists
        ];

        $response = $this->post(route('project.store'), $invalidData);

        $response->assertStatus(302);
    }

    /** @test */
    public function project_with_duplicate_title()
    {
        $duplicateData = [
            'title' => 'Duplicate Title',
            'description' => 'This is a test project description t description t description.', // Ensure description is provided
            'team_size' => 5,
            'trimester' => 2,
            'year' => 2023,
            'coordinator_name' => 'John Doe',
            'coordinator_email' => 'john.doe@example.com',
            'complexity' => 'Medium',
            'inpID' => 1,
        ];

        $response = $this->post(route('project.store'), $duplicateData);

        $duplicateData2 = [
            'title' => 'Duplicate Title',
            'description' => 'This is a test project description t description t description.', // Ensure description is provided
            'team_size' => 5,
            'trimester' => 2,
            'year' => 2023,
            'coordinator_name' => 'John Doe',
            'coordinator_email' => 'john.doe@example.com',
            'complexity' => 'Medium',
            'inpID' => 1,
        ];

        $response = $this->post(route('project.store'), $duplicateData2);

        $response->assertStatus(302);
    }

    /** @test */
    public function it_can_delete_a_project_successfully()
    {
        // Assuming inpID references a user's ID in the users table
        $user = User::factory()->create(); // Create a user

        $projectData = [
            'title' => 'Test Project for Deletion',
            'description' => 'This is a test project description for deletion.',
            'team_size' => 5,
            'trimester' => 2,
            'year' => 2023,
            'coordinator_name' => 'John Doe',
            'coordinator_email' => 'john.doe@example.com',
            'complexity' => 'Medium',
            'inpID' => 1,
        ];
        $project = Project::factory()->create($projectData);

        $response = $this->delete(route('project.destroy', $project->id));

        $response->assertStatus(302);
    }

        /** @test */
        public function it_cannot_delete_a_nonexistent_project()
        {
            $response = $this->delete(route('project.destroy', 999)); // Assuming 999 is a non-existent ID

            $response->assertStatus(302);
        }
    }
