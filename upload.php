<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize form inputs
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    // Resume upload setup
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = basename($_FILES["resume"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Allowed file types
    $allowedTypes = ['pdf', 'doc', 'docx'];

    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["resume"]["tmp_name"], $targetFilePath)) {

            // ✅ 1. Email to Employer
            $toEmployer = "employer@example.com"; // Replace with your email
            $subjectEmployer = "New Job Application: $name";
            $bodyEmployer = "Name: $name\nEmail: $email\nMessage: $message\nResume: $targetFilePath";
            $headersEmployer = "From: $email";

            mail($toEmployer, $subjectEmployer, $bodyEmployer, $headersEmployer);

            // ✅ 2. Email Confirmation to Applicant
            $toApplicant = $email;
            $subjectApplicant = "Application Received - Baroque Amoka Careers";
            $bodyApplicant = "Dear $name,\n\nThank you for applying for the position. We have received your application and will review it shortly.\n\nBest regards,\nBaroque Amoka Careers Team";
            $headersApplicant = "From: no-reply@baroqueamoka.com";

            mail($toApplicant, $subjectApplicant, $bodyApplicant, $headersApplicant);

            echo "<script>alert('Application submitted successfully. Confirmation email sent.'); window.history.back();</script>";
        } else {
            echo "<script>alert('Resume upload failed.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Only PDF, DOC, or DOCX files are allowed.'); window.history.back();</script>";
    }
}
?>
