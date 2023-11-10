<?php

namespace Database\Seeders;

use App\Models\Tour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            Tour::create([
                'id' => $tour['id'],
                'travelId' => $tour['travelId'],
                'name' => $tour['name'],
                'startingSate' => $tour['startingDate'],
                'endingDate' => $tour['endingDate'],
                'price' => $tour['price'],
            ]);
        }
    }
}
