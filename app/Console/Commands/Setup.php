<?php

namespace App\Console\Commands;

use App\Role;
use Illuminate\Console\Command;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup this tool by adding defaults to the database';

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
        $this->info('Inserting default roles');
        $this->comment('[admin, developer, user]');
        Role::create([
            'name' => 'admin'
        ]);
        Role::create([
            'name' => 'developer'
        ]);
        Role::create([
            'name' => 'user'
        ]);

        $this->info('Complete');

    }
}
