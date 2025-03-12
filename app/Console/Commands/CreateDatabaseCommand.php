<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDatabaseCommand extends Command
{
    protected $signature = 'db:create {name}';
    protected $description = 'Create a new database';

    public function handle()
    {
        $database = $this->argument('name');
        DB::statement("CREATE DATABASE IF NOT EXISTS $database");
        $this->info("Database '$database' created successfully!");
    }
}
