<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ChangeRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change-role {userId} {newRole}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the role of a user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userId = $this->argument('userId');
        $newRole = $this->argument('newRole');

        $user = User::find($userId);
        $user->role = $newRole;
        $user->save();

        $this->info("User role updated successfully.");
    }

}
