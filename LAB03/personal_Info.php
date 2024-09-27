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
    $full_name = htmlspecialchars($_POST['full_name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);

    // Validate inputs
    if ($full_name && $email && $phone) {
        // Store data in session
        $_SESSION['full_name'] = $full_name;
        $_SESSION['email'] = $email; // Overwrite the session email if needed
        $_SESSION['phone'] = $phone;

        // Redirect to the next step
        header("Location: edu_Info.php");
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
    <title>Personal Information</title>
</head>
<body>
    <h2>Step 1: Personal Information</h2>
    <form action="personal_Info.php" method="POST">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" required><br><br>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" value="<?php echo $_SESSION['email'] ?? ''; ?>" required><br><br>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required><br><br>

        <input type="submit" value="Next">
    </form>
    <?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>
</body>
</html>
