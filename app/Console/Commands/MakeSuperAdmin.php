<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class MakeSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:superadmin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign the SuperAdmin role to a user';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('User with email $email does not exist.');
            return;
        }

        $user->assignRole(Role::findOrCreate('SuperAdmin', 'web'));

        $this->info("User $user->email is now SuperAdmin.");
    }
}
