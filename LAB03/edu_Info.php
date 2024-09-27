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
    $degree = htmlspecialchars($_POST['degree']);
    $field_of_study = htmlspecialchars($_POST['field_of_study']);
    $institution = htmlspecialchars($_POST['institution']);
    $graduation_year = htmlspecialchars($_POST['graduation_year']);

    // Validate inputs
    if ($degree && $field_of_study && $institution && $graduation_year) {
        // Store data in session
        $_SESSION['degree'] = $degree;
        $_SESSION['field_of_study'] = $field_of_study;
        $_SESSION['institution'] = $institution;
        $_SESSION['graduation_year'] = $graduation_year;

        // Redirect to the next step
        header("Location: work_Info.php");
        exit();
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
    <title>Educational Background</title>
</head>
<body>
    <h2>Step 2: Educational Background</h2>
    <form action="edu_Info.php" method="POST">
        <label for="degree">Highest Degree Obtained:</label>
        <input type="text" id="degree" name="degree" required><br><br>

        <label for="field_of_study">Field of Study:</label>
        <input type="text" id="field_of_study" name="field_of_study" required><br><br>

        <label for="institution">Name of Institution:</label>
        <input type="text" id="institution" name="institution" required><br><br>

        <label for="graduation_year">Year of Graduation:</label>
        <input type="text" id="graduation_year" name="graduation_year" required><br><br>

        <input type="submit" value="Next">
    </form>
    <?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>
</body>
</html>
