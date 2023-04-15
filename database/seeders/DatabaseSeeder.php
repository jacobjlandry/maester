<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // lets just start with a few tasks for now
        $task = new \App\Models\Task();
        $task->title = "Test Task";
        $task->description = "This is a test task";
        $task->type = "checkbox";
        $task->save();

        $taskTwo = new \App\Models\Task();
        $taskTwo->parent_id = $task->id;
        $taskTwo->title = "Subtask";
        $taskTwo->description = "This is a subtask";
        $taskTwo->type = "checkbox";
        $taskTwo->save();

        $taskThree = new \App\Models\Task();
        $taskThree->title = "Another Task";
        $taskThree->description = "Testing flexibility";
        $taskThree->type = "folder";
        $taskThree->icon = "foldericn";
        $taskThree->security = 12345;
        $taskThree->save();
    }
}
