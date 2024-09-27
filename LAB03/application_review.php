<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Handle final submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare the application data
    $application_data = [
        'full_name' => $_SESSION['full_name'],
        'email' => $_SESSION['email'],
        'phone' => $_SESSION['phone'],
        'degree' => $_SESSION['degree'],
        'field_of_study' => $_SESSION['field_of_study'],
        'institution' => $_SESSION['institution'],
        'graduation_year' => $_SESSION['graduation_year'],
        'job_title' => $_SESSION['job_title'],
        'company_name' => $_SESSION['company_name'],
        'years_of_experience' => $_SESSION['years_of_experience'],
        'key_responsibilities' => $_SESSION['key_responsibilities'],
    ];

    // Save application data to applications.json
    $file = 'applications.json';
    if (file_exists($file)) {
        $applications = json_decode(file_get_contents($file), true);
    } else {
        $applications = [];
    }
    $applications[] = $application_data;
    file_put_contents($file, json_encode($applications));

    // Simulate sending a confirmation email
    $to = $_SESSION['email'];
    $subject = "Job Application Confirmation";
    $message = "Thank you for your application, " . $_SESSION['full_name'] . "!\n\nYour application details:\n" . print_r($application_data, true);
    // mail($to, $subject, $message); // Uncomment to enable email sending in a real environment

    // Clear session data
    session_destroy();

    echo "Application submitted successfully! A confirmation email has been sent.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Your Application</title>
</head>
<body>
    <h2>Review Your Application</h2>
    <h3>Personal Information</h3>
    <p><strong>Full Name:</strong> <?php echo $_SESSION['full_name']; ?></p>
    <p><strong>Email Address:</strong> <?php echo $_SESSION['email']; ?></p>
    <p><strong>Phone Number:</strong> <?php echo $_SESSION['phone']; ?></p>

    <h3>Educational Background</h3>
    <p><strong>Highest Degree Obtained:</strong> <?php echo $_SESSION['degree']; ?></p>
    <p><strong>Field of Study:</strong> <?php echo $_SESSION['field_of_study']; ?></p>
    <p><strong>Name of Institution:</strong> <?php echo $_SESSION['institution']; ?></p>
    <p><strong>Year of Graduation:</strong> <?php echo $_SESSION['graduation_year']; ?></p>

    <h3>Work Experience</h3>
    <p><strong>Previous Job Title:</strong> <?php echo $_SESSION['job_title']; ?></p>
    <p><strong>Company Name:</strong> <?php echo $_SESSION['company_name']; ?></p>
    <p><strong>Years of Experience:</strong> <?php echo $_SESSION['years_of_experience']; ?></p>
    <p><strong>Key Responsibilities:</strong> <?php echo $_SESSION['key_responsibilities']; ?></p>

    <form action="application_review.php" method="POST">
        <input type="submit" value="Submit Application">
    </form>

    <h3>Edit Your Information</h3>
    <ul>
        <li><a href="personal_Info.php">Edit Personal Information</a></li>
        <li><a href="edu_Info.php">Edit Educational Background</a></li>
        <li><a href="work_Info.php">Edit Work Experience</a></li>
    </ul>
</body>
</html>
