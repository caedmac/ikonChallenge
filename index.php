<?php
include($_SERVER['DOCUMENT_ROOT']."/fileActionsChallenge.php");
include($_SERVER['DOCUMENT_ROOT']."/device.php");
include($_SERVER['DOCUMENT_ROOT']."/validTasks.php");

$lines = openChallengeFile();
$devices = getDevices($lines);
$validTasks = getValidTasks($devices);
writeFile($validTasks);