<?php

namespace App\Traits;

use App\Models\User;

trait UserWithRole
{
    public function createUserWithRole(string $roleName)
    {

        $user = null;

        switch ($roleName) {
            case 'admin':
                $user = User::create([
                    'name' => 'Admin',
                    'email' => 'admin@example.com',
                    'password' => bcrypt('password'),
                ]);
                $user->roles()->attach(['baf18948-721e-49f5-aa7f-bed1a5415cb6', '9442703c-dd4f-4e36-9554-a60574c408be']);
                break;

            case 'editor':
                $user = User::create([
                    'name' => 'Editor',
                    'email' => 'editor@example.com',
                    'password' => bcrypt('password'),
                ]);
                $user->roles()->attach('9442703c-dd4f-4e36-9554-a60574c408be');
                break;

            default:
                break;
        }

        return $user;
    }
}
