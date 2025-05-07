<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $company = htmlspecialchars($_POST['company']);
    $location = htmlspecialchars($_POST['location']);
    $type = htmlspecialchars($_POST['type']);
    $description = htmlspecialchars($_POST['description']);

    $jobData = "$title|$company|$location|$type|$description\n";

    file_put_contents('jobs.txt', $jobData, FILE_APPEND);

    echo "<h2>Job posted successfully!</h2><a href='employer-dashboard.html'>Go to Dashboard</a>";
} else {
    echo "Invalid request.";
}
?>
