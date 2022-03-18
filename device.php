<?php

function getDevices(array $lines): array{
    $devices = [];
    $i = 0;
    $j = 0;
    while ($i < count($lines)) {
        if (is_numeric(rtrim($lines[$i]))) {
            $devices[$j] = [
                'resource' => intval(rtrim($lines[$i])),
                'foreGroundTasks' => cleanLine($lines[$i + 1]), //Clean the string and convert to Int
                'backGroundTasks' => cleanLine($lines[$i + 2]),
            ];
        }
        $i = $i + 3;
        $j++;
    }

    return $devices;
}

function cleanLine(string $line): array {
    $taskString = str_replace('(', '', rtrim($line));
    $taskString = str_replace(')', '', rtrim($taskString));
    $listTask = explode(',', rtrim($taskString));

    $tasks = [];
    foreach ($listTask as $item) {
        if (is_numeric($item)) {
            $tasks[] = rtrim($item);
        }
    }

    $list = [];
    for ($i = 0; $i < count($tasks); $i++) {
        if ($i % 2 == 0) {
            $list [] = [
                'id' => intval($tasks[$i]),
                'consume' => intval($tasks[$i + 1]),
            ];
        }
    }
    return $list;
}