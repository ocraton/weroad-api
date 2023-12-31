<?php

namespace Database\Seeders;

use App\Models\Tour;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('samples/tours.json'));
        $data = json_decode($json, true);

        foreach ($data as $tour) {
            Tour::withoutEvents(function () use ($tour) {
                Tour::create([
                    'id' => $tour['id'],
                    'travelId' => $tour['travelId'],
                    'name' => $tour['name'],
                    'startingDate' => $tour['startingDate'],
                    'endingDate' => $tour['endingDate'],
                    'price' => $tour['price'],
                ]);
            });
        }
    }
}
