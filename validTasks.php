<?php

function getValidTasks(array $devices): array{
    $validTasks = [];
    $i = 0;
    foreach ($devices as $device) {
        $validTasks[$i] = getConsumeEqualToResource($device);

        if (count($validTasks[$i]) === 0) { //If is not equal, search for the closest one
            $validTasks[$i] = getConsumeClosestToResource($device);
        }
        $i++;
    }
    return $validTasks;
}

function getConsumeEqualToResource(array $device): array {
    $equalTasks = [];
    foreach ($device['foreGroundTasks'] as $foreGroundTask) {
        foreach ($device['backGroundTasks'] as $backGroundTask) {
            $consume = $foreGroundTask['consume'] + $backGroundTask['consume'];
            if ($device['resource'] === $consume) {
                $equalTasks[] = [
                    'foreGroundId' => $foreGroundTask['id'],
                    'backGroundId' => $backGroundTask['id'],
                ];
            }
        }
    }

    return $equalTasks;
}

function getConsumeClosestToResource(array $device): array {
    $closestTask = [];

    foreach ($device['backGroundTasks'] as $backGroundTask) {
        foreach ($device['foreGroundTasks'] as $foreGroundTask) {
            $consume = $foreGroundTask['consume'] + $backGroundTask['consume'];
            if ($consume <= $device['resource']) {
                $closestTask[] = [
                    'consumeSum' => $consume,
                    'foreGroundId' => $foreGroundTask['id'],
                    'backGroundId' => $backGroundTask['id'],
                ];
            }
        }
    }

    return getClosest($device['resource'], $closestTask);
}

function getClosest(int $resource, array $array): array {
    $closest = null;
    $task = [];
    foreach ($array as $item) {
        if ($closest === null || abs($resource - $closest['consumeSum']) > abs($item['consumeSum'] - $resource)) {
            $closest = $item;
        }
    }

    $task[] = $closest;  //This is to keep the format used
    return $task;
}