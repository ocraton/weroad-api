<?php

namespace Database\Seeders;

use App\Models\Travel;
use Illuminate\Database\Seeder;

class TravelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('samples/travels.json'));
        $data = json_decode($json, true);

        foreach ($data as $travel) {
            Travel::withoutEvents(function () use ($travel) {
                Travel::create([
                    'id' => $travel['id'],
                    'slug' => $travel['slug'],
                    'name' => $travel['name'],
                    'description' => $travel['description'],
                    'numberOfDays' => $travel['numberOfDays'],
                    'moods' => $travel['moods'],
                ]);
            });
        }
    }
}
