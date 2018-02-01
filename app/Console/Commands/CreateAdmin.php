<?php

namespace App\Console\Commands;

use App\Role;
use App\User;
use Illuminate\Console\Command;
use Auth;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set a user as an admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = $this->ask('Username');
        $password = $this->secret('Password');

        $userInfo = [
            'email' => $user,
            'password' => $password
        ];

        if(Auth::attempt($userInfo)) {
            $admin = Role::where('name', 'admin')->first();

            User::where('email', $user)
                ->first()
                ->roles()
                ->attach($admin);

            $this->info($user . ' is now an admin.');
        }
        else {
            $this->error('Failed to find user. Please check your info and try again.');
        }
    }
}
