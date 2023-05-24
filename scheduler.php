<?php

require_once 'vendor/autoload.php';

use App\Commands\AddTaskCommand;
use App\Scheduling\Scheduler;
use App\Storage\Database;

// Instantiate the required objects
$database = new Database();
$command = new AddTaskCommand($database);
$scheduler = new Scheduler($database);

// Run the scheduler
$scheduler->run();