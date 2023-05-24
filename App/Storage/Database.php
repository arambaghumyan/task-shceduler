<?php

namespace App\Storage;

class Database
{
    private $tasks = [];

    public function addTask($task, $time)
    {
        $this->tasks[] = [
            'task' => $task,
            'time' => $time
        ];
    }

    public function saveTasksToDb()
    {
        file_put_contents($this->getDbPath(), '', 0  | LOCK_EX);

        foreach ($this->tasks as $task) {
            $job = $task['time'] . ':' . $task['task'] . "\n";

            file_put_contents($this->getDbPath(), $job, FILE_APPEND | LOCK_EX);
        }
    }

    public function getPendingTasks($fromDb = false)
    {
        if ($fromDb && !empty($this->getDbContent())) {
            $taskData = explode("\n", $this->getDbContent());

            foreach ($taskData as $data) {
                $data = explode(":", $data);

                $this->addTask($data[1], $data[0]);
            }
        }

        $currentTime = time();

        return array_filter($this->tasks, function ($task) use ($currentTime) {
            return $task['time'] <= $currentTime;
        });
    }

    public function removeTask($task, $fromDb = false)
    {
        $tasks = [];

        foreach ($this->tasks as $_task) {
            if ($_task['task'] != $task['task']) {
                $tasks[] = $_task;
            }
        }

        $this->tasks = $tasks;

        if ($fromDb) {
            $this->saveTasksToDb();
        }
    }

    public function getDbPath()
    {
        return __DIR__ . '/../../database.txt';
    }

    public function getDbContent()
    {
        $myfile = fopen($this->getDbPath(), "r") or die("Unable to open file!");

        $content = fgets($myfile);

        fclose($myfile);

        return trim($content);
    }

    public function setTasks(array $tasks)
    {
        $this->tasks = $tasks;
    }
}