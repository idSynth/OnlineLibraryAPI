<?php

namespace App\Console\Commands;

use App\Models\Users;
use Illuminate\Console\Command;

class changeRoleCommand extends Command
{
    protected $signature = 'change:role {user}';

    protected $description = 'Changes the selected users role';

    public function handle(): void
    {
        $userId = $this->argument('user');
        if(Users::find($userId))
        {
            $roleName = $this->choice('Assign new role', ['user','admin'], 'user');
            Users::find($userId) -> update(['role' => "$roleName"]);
        }
        else
        {
            $this->error('User is invalid');
        }
    }
}
