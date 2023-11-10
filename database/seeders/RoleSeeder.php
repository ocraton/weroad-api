<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('samples/roles.json'));
        $data = json_decode($json, true);

        foreach ($data as $role) {
            Role::create([
                'id' => $role['id'],
                'name' => $role['name'],
            ]);
        }
    }
}
