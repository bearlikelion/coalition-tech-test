<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;

class ProjectTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $projects = [
            'Personal',
            'Work',
            'Open Source',
        ];

        $priority = 1;

        foreach ($projects as $projectName) {
            $project = Project::create(['name' => $projectName]);
            
            for ($i = 1; $i <= 5; $i++) {
                // Fake task creation
                Task::create([
                    'project_id' => $project->id,
                    'name' => $faker->sentence(4),
                    'priority' => $priority++,
                ]);
            }
        }
    }
}
