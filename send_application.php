<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $linkedin = htmlspecialchars($_POST['linkedin']);
    $cover_letter = htmlspecialchars($_POST['cover_letter']);
    $expected_salary = htmlspecialchars($_POST['expected_salary']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $job_id = htmlspecialchars($_POST['job_id']);
    $job_title = htmlspecialchars($_POST['job_title']);

    // Email settings
    $to = "youremail@example.com"; // HR/Recruiter's email
    $subject = "New Application for $job_title";
    $boundary = md5("boundary" . time());

    // Email headers
    $headers = "From: $fullname <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    // Email body with applicant details
    $message = "--$boundary\r\n";
    $message .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
    $message .= "A new job application has been submitted.\n\n";
    $message .= "Job Title: $job_title\nJob ID: $job_id\n\n";
    $message .= "Full Name: $fullname\n";
    $message .= "Email: $email\n";
    $message .= "Phone: $phone\n";
    $message .= "LinkedIn: $linkedin\n";
    $message .= "Expected Salary: $expected_salary\n";
    $message .= "Available Start Date: $start_date\n\n";
    $message .= "Cover Letter:\n$cover_letter\n\n";

    // Handle resume attachment
    if (!empty($_FILES['resume']['tmp_name'])) {
        $resume_file = $_FILES['resume']['tmp_name'];
        $resume_name = $_FILES['resume']['name'];
        $resume_type = $_FILES['resume']['type'];
        $resume_data = chunk_split(base64_encode(file_get_contents($resume_file)));

        $message .= "--$boundary\r\n";
        $message .= "Content-Type: $resume_type; name=\"$resume_name\"\r\n";
        $message .= "Content-Disposition: attachment; filename=\"$resume_name\"\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $message .= $resume_data . "\r\n";
    }

    // Handle optional portfolio attachment
    if (!empty($_FILES['portfolio']['tmp_name'])) {
        $portfolio_file = $_FILES['portfolio']['tmp_name'];
        $portfolio_name = $_FILES['portfolio']['name'];
        $portfolio_type = $_FILES['portfolio']['type'];
        $portfolio_data = chunk_split(base64_encode(file_get_contents($portfolio_file)));

        $message .= "--$boundary\r\n";
        $message .= "Content-Type: $portfolio_type; name=\"$portfolio_name\"\r\n";
        $message .= "Content-Disposition: attachment; filename=\"$portfolio_name\"\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $message .= $portfolio_data . "\r\n";
    }

    $message .= "--$boundary--";

    // Send email to admin
    $mail_sent = mail($to, $subject, $message, $headers);

    // Send confirmation to applicant
    $confirmation_subject = "Application Received: $job_title";
    $confirmation_message = "Dear $fullname,\n\nThank you for applying for the position of \"$job_title\".\n\nWe have received your application and will review it shortly.\n\nBest regards,\nBaroque Amoka Careers Team";
    $confirmation_headers = "From: careers@baroqueamoka.com\r\n";

    mail($email, $confirmation_subject, $confirmation_message, $confirmation_headers);

    // Redirect to success page
    if ($mail_sent) {
        header("Location: application-success.html");
        exit();
    } else {
        echo "There was an error sending the email. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
?>
