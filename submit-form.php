<?php
// filepath: c:\Users\bugsy\Downloads\Jobs\submit-form.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "All required fields must be filled out.";
        exit;
    }

    // Send email (example)
    $to = "info@baroqueamoka.com";
    $headers = "From: $email";
    $emailBody = "Name: $name\nEmail: $email\nPhone: $phone\nSubject: $subject\nMessage:\n$message";

    if (mail($to, $subject, $emailBody, $headers)) {
        echo "Thank you for contacting us, $name. We will get back to you shortly.";
    } else {
        echo "Sorry, there was an error sending your message. Please try again later.";
    }
} else {
    echo "Invalid request method.";
}
?>