<?php

function openChallengeFile(): array {
    $readFile = fopen("Resources/challenge.in", "r") or exit("Unable to open file!");
    $lines = [];
    while (!feof($readFile)) {
        $lines[] = fgets($readFile);
    }
    fclose($readFile);

    return $lines;
}

function writeFile(array $validTasks): void {
    $writeFile = 'Resources/challenge.out';

    if (!file_exists($writeFile)) {
        print 'File not found';
    } else if (!$handler = fopen($writeFile, 'w+')) {
        print 'Can not open file';
    } else {
        foreach ($validTasks as $validTask) {
            for ($i = 0; $i < count($validTask); $i++) {
                fwrite($handler, '(' . $validTask[$i]['foreGroundId'] . ',' . $validTask[$i]['backGroundId'] . ')');
                if ($i < count($validTask) - 1) {
                    fwrite($handler, ', ');
                }
            }
            fwrite($handler, PHP_EOL);
        }
        fclose($handler);
    }
}