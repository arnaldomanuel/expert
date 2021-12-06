<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Queue\Jobs\DatabaseJob;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder = new \Database\Seeders\TokenSeeder();
        $seeder->run();
    }
}
