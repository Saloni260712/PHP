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
    <title>Step 1: Personal Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .progress {
            width: 100%;
            background-color: #f4f4f4;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .progress-bar {
            width: 33%;
            background-color: #4CAF50;
            padding: 10px 0;
            color: white;
            text-align: center;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Ensures padding doesn't increase width */
        }
        input[type="submit"] {
            margin-top: 10px;
            width: 100%;
            padding: 10px;
            background: #5cb85c;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #4cae4c;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #d9534f; /* Bootstrap danger color */
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background: #c9302c;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Step 1: Personal Information</h2>

    <!-- Progress bar -->
    <div class="progress">
        <div class="progress-bar">Step 1 of 3</div>
    </div>

    <form action="personal_Info.php" method="POST">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" required value="<?php echo $_SESSION['full_name'] ?? ''; ?>">

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" value="<?php echo $_SESSION['email'] ?? ''; ?>" required>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required value="<?php echo $_SESSION['phone'] ?? ''; ?>">

        <input type="submit" value="Next">
        <button onclick="window.location.href='login.html'; return false;">Logout</button>
    </form>
    <?php if (isset($error_message)) echo "<p class='error'>$error_message</p>"; ?>
</div>

</body>
</html>
