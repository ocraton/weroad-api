<?php

use App\Models\Travel;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    Travel::create([
        'id' => 'd408be33-aa6a-4c73-a2c8-58a70ab2ba4d',
        'slug' => 'jordan-360',
        'name' => 'name',
        'description' => 'description',
        'numberOfDays' => 2,
        'moods' => 'moods',
    ]);

    return view('welcome');
});
