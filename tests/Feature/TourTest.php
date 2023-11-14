<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\Travel;
use App\Traits\UserWithRole;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TourSeeder;
use Database\Seeders\TravelSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TourTest extends TestCase
{
    use RefreshDatabase, UserWithRole;

    public function test_all_users_can_view_tour_list_by_travel_slug(): void
    {

        $this->seed(TravelSeeder::class);

        $this->seed(TourSeeder::class);

        $travel = Travel::first();

        $travel->isPublic = true; // the travel must be public

        $travel->save();

        $response = $this->getJson("/api/travels/{$travel->slug}/tours");

        $response->assertStatus(200);

        $tours = Tour::where('travelId', $travel->id)->count();

        $response->assertJsonCount($tours, 'data');
    }

    public function test_admin_can_create_tour()
    {
        $this->seed(RoleSeeder::class);

        $this->seed(TravelSeeder::class);

        $admin = $this->createUserWithRole('admin');

        $this->actingAs($admin);

        $travel = Travel::first();

        $tourData = [
            'travelId' => $travel->id,
            'name' => 'Magical Mystery Tour',
            'startingDate' => '2023-12-01',
            'endingDate' => '2023-12-10',
        ];

        $response = $this->postJson('api/admin/tours', $tourData + ['price' => 100000]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tours', $tourData + ['price' => 10000000]);

    }

    public function test_editor_cannot_create_tour()
    {
        $this->seed(RoleSeeder::class);

        $this->seed(TravelSeeder::class);

        $editor = $this->createUserWithRole('editor');

        $this->actingAs($editor);

        $travel = Travel::first();

        $tourData = [
            'travelId' => $travel->id,
            'name' => 'Magical Mystery Tour',
            'startingDate' => '2023-12-01',
            'endingDate' => '2023-12-10',
        ];

        $response = $this->postJson('api/admin/tours', $tourData + ['price' => 100000]);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('tours', $tourData + ['price' => 10000000]);

    }
}
