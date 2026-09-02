<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetUserPassword extends Command
{
    // Command signature: php artisan reset:user-password {email} {password}
    protected $signature = 'reset:user-password {email} {password}';

    protected $description = 'Reset a user password by email';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1; // Error
        }

        $user->password = Hash::make($password);
        $user->save();

        $this->info("Password for {$email} has been reset successfully!");
        return 0; // Success
    }
}
