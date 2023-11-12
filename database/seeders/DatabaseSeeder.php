<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            TravelSeeder::class,
            TourSeeder::class,
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@example.com',
            'password' => bcrypt('password'),
        ]);

        $admin->roles()->attach(['baf18948-721e-49f5-aa7f-bed1a5415cb6', '9442703c-dd4f-4e36-9554-a60574c408be']); // admin user will also have the editor role

        $editor->roles()->attach('9442703c-dd4f-4e36-9554-a60574c408be');

    }
}
