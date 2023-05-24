<?php

namespace App\Commands;

use App\Storage\Database;
use App\Utils\TimeUtils;

class AddTaskCommand
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function pushToQueue(array $args)
    {
        $time = TimeUtils::parseTimeArgument($args[0]);

        $task = $args[1];

        $this->database->addTask($task, $time);

        $this->database->saveTasksToDb();
    }
}