<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = htmlspecialchars($_POST['title']);
    $company = htmlspecialchars($_POST['company']);
    $location = htmlspecialchars($_POST['location']);
    $type = htmlspecialchars($_POST['type']);
    $description = htmlspecialchars($_POST['description']);

    $jobs = file("jobs.txt", FILE_IGNORE_NEW_LINES);
    if (isset($jobs[$id])) {
        $jobs[$id] = "$title|$company|$location|$type|$description";
        file_put_contents("jobs.txt", implode("\n", $jobs));
        header("Location: employer-dashboard.php");
        exit();
    } else {
        echo "Job not found.";
    }
} else {
    echo "Invalid request.";
}
