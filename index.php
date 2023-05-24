<?php

require_once 'vendor/autoload.php';

use App\Commands\AddTaskCommand;
use App\Scheduling\Scheduler;
use App\Storage\Database;

$database = new Database();
$command = new AddTaskCommand($database);
$scheduler = new Scheduler($database);

$arguments = $argv;
array_shift($arguments);

$command->pushToQueue($arguments);