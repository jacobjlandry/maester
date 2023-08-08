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
        $task->type = "task";
        $task->user_id = 1;
        $task->save();

        $taskTwo = new \App\Models\Task();
        $taskTwo->parent_id = $task->id;
        $taskTwo->title = "Subtask";
        $taskTwo->description = "This is a subtask";
        $taskTwo->type = "task";
        $taskTwo->user_id = 1;
        $taskTwo->save();

        $taskThree = new \App\Models\Task();
        $taskThree->title = "Another Task";
        $taskThree->description = "Testing flexibility";
        $taskThree->type = "folder";
        $taskThree->security = 12345;
        $taskThree->user_id = 1;
        $taskThree->save();

        $taskFour = new \App\Models\Task();
        $taskFour->title = "This task is due";
        $taskFour->description = "Testing due dates";
        $taskFour->type = "task";
        $taskFour->due_datetime = Date('Y-m-d H:i:s');
        $taskFour->user_id = 1;
        $taskFour->save();

        $taskFive = new \App\Models\Task();
        $taskFive->title = "This task is due tomorrow";
        $taskFive->description = "Testing due dates";
        $taskFive->type = "task";
        $taskFive->due_datetime = Date('Y-m-d H:i:s', strtotime('+1 day'));
        $taskFive->user_id = 1;
        $taskFive->save();
    }
}
