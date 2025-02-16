<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CustomCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $commands = 'php artisan optimize && php artisan config:cache && php artisan config:clear'; // Replace with your actual commands

        // Execute the commands
        $output = shell_exec($commands);
        return $output;
    }
}
