<?php

namespace Tests\Feature;

use App\Models\Travel;
use App\Traits\UserWithRole;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TravelSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TravelTest extends TestCase
{
    use RefreshDatabase, UserWithRole;

    /**
     * A basic feature test example.
     */
    public function test_all_users_can_view_travel_list(): void
    {

        $this->seed(TravelSeeder::class);

        $response = $this->getJson('/api/travels');

        $response->assertStatus(200);

        $publicTravelsCount = Travel::where('isPublic', true)->count();

        $response->assertJsonCount($publicTravelsCount, 'data');

    }

    public function test_admin_can_create_travel()
    {
        $this->seed(RoleSeeder::class);

        $admin = $this->createUserWithRole('admin');

        $this->actingAs($admin);

        $travelData = [
            'name' => 'Magical Mystery Travel',
            'description' => 'Test Description',
            'isPublic' => 1,
            'numberOfDays' => 10,
            'moods' => json_encode(['nature' => 100, 'relax' => 30]),
        ];

        $response = $this->postJson('api/admin/travels', $travelData);

        // 201 (Created)
        $response->assertStatus(201);

        $this->assertDatabaseHas('travel', $travelData);

    }

    public function test_editor_cannot_create_travel()
    {
        $this->seed(RoleSeeder::class);

        $editor = $this->createUserWithRole('editor');

        $this->actingAs($editor);

        $travelData = [
            'name' => 'Magical Mystery Travel',
            'description' => 'Test Description',
            'isPublic' => 1,
            'numberOfDays' => 10,
            'moods' => json_encode(['nature' => 100, 'relax' => 30]),
        ];

        $response = $this->postJson('api/admin/travels', $travelData);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('travel', $travelData);
    }

    public function test_only_editor_can_update_travel()
    {
        $this->seed(RoleSeeder::class);

        $this->seed(TravelSeeder::class);

        $editor = $this->createUserWithRole('editor');

        $this->actingAs($editor);

        $travel = Travel::first();

        $travelData = [
            'name' => 'Magical Mystery Updated',
            'description' => 'Test Description',
            'isPublic' => 1,
            'numberOfDays' => 10,
            'moods' => json_encode(['nature' => 100, 'relax' => 30]),
        ];

        $response = $this->put("/api/editor/travels/$travel->id", $travelData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('travel', $travelData);

    }
}
