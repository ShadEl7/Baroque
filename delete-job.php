<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $file = 'jobs.txt';
    $jobs = file($file, FILE_IGNORE_NEW_LINES);
    if (isset($jobs[$id])) {
        unset($jobs[$id]);
        file_put_contents($file, implode("\n", $jobs));
    }
}
header("Location: employer-dashboard.php");
exit();
