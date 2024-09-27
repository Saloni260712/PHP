<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $job_title = htmlspecialchars($_POST['job_title']);
    $company_name = htmlspecialchars($_POST['company_name']);
    $years_of_experience = htmlspecialchars($_POST['years_of_experience']);
    $key_responsibilities = htmlspecialchars($_POST['key_responsibilities']);

    // Validate inputs
    $error_message = '';
    if ($job_title && $company_name && $key_responsibilities) {
        // Check if years of experience is a positive integer
        if (is_numeric($years_of_experience) && $years_of_experience > 0) {
            // Store data in session
            $_SESSION['job_title'] = $job_title;
            $_SESSION['company_name'] = $company_name;
            $_SESSION['years_of_experience'] = $years_of_experience;
            $_SESSION['key_responsibilities'] = $key_responsibilities;

            // Redirect to the review page
            header("Location: application_review.php");
            exit();
        } else {
            $error_message = "Please enter a valid positive number for years of experience.";
        }
    } else {
        $error_message = "Please fill all fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Experience</title>
</head>
<body>
    <h2>Step 3: Work Experience</h2>
    <form action="work_Info.php" method="POST">
        <label for="job_title">Previous Job Title:</label>
        <input type="text" id="job_title" name="job_title" required><br><br>

        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" required><br><br>

        <label for="years_of_experience">Years of Experience:</label>
        <input type="number" id="years_of_experience" name="years_of_experience" required min="1"><br><br>

        <label for="key_responsibilities">Key Responsibilities:</label><br>
        <textarea id="key_responsibilities" name="key_responsibilities" rows="4" required></textarea><br><br>

        <input type="submit" value="Next">
    </form>
    <?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>
</body>
</html>
