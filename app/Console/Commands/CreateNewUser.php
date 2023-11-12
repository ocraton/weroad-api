<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreateNewUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        do{
            $name = $this->ask('Please provide a Name');
            $validator = Validator::make(['name' => $name], ['name' => 'required|string|max:100']);
            $this->error($validator->errors()->first('name'));
        } while ($validator->fails());

        do{
            $email = $this->ask('Please provide an Email');
            $validator = Validator::make(['email' => $email], ['email' => 'required|email|unique:users,email']);
            $this->error($validator->errors()->first('email'));
        } while ($validator->fails());

        do{
            $password = $this->secret('Please provide a password');
            $validator = Validator::make(['password' => $password], ['password' => 'required']);
            $this->error($validator->errors()->first('password'));
        } while ($validator->fails());

        try{

            $roles = Role::all();

            $roleChoice = $this->choice('Set the role for the user:', $roles->pluck('name')->toArray(), 1);

        } catch (\Exception $e) {

            $this->error('Role not found');

            return -1;
        }

        $role = $roles->first(function ($role) use ($roleChoice) {
            return $role->name === $roleChoice;
        });

        DB::transaction(function () use ($name, $email, $password, $role, $roles, $roleChoice) {

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password)
            ]);

            if ($roleChoice === 'admin') {
                // admin user will also have the editor role
                $editorRole = $roles->first(function ($role) {
                    return $role->name === 'editor';
                });
                $user->roles()->attach([$role->id, $editorRole->id]);
            } else {
                $user->roles()->attach([$role->id]);
            }

        });

        $this->info("User $name created successfully!");

    }

}
