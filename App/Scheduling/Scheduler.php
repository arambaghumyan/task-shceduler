<?php
namespace App\Scheduling;

use App\Storage\Database;

class Scheduler
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function run()
    {
        while (true) {
            $this->database->setTasks([]);

            $tasks = $this->database->getPendingTasks(true);

            foreach ($tasks as $task) {
                // Execute the task
                $this->executeTask($task);

                // Remove the task from the database.txt
                $this->database->removeTask($task, true);
            }
        }
    }

    private function executeTask($task)
    {
        // Perform the task execution logic
        echo "Executing task: " . $task['task'] . PHP_EOL;
    }
}