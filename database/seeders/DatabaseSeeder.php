<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         User::factory()->create([
             'name' => 'Amitav Roy',
             'email' => 'reachme@amitavroy.com',
             'password' => bcrypt('Password@123'),
             'gitlab_id' => 917644,
         ]);

        Project::factory()->count(20)->create();
    }
}
