<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Initialize error messages
$full_name_error = $email_error = $phone_error = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $full_name = htmlspecialchars($_POST['full_name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);

    // Validate inputs
    $valid = true;

    // Check full name
    if (empty($full_name)) {
        $full_name_error = "Please enter your full name.";
        $valid = false;
    }

    // Check email
    if (empty($_POST['email'])) {
        $email_error = "Please enter your email address.";
        $valid = false;
    } elseif (!$email) {
        $email_error = "Invalid email format.";
        $valid = false;
    }

    // Check phone number
    if (empty($phone)) {
        $phone_error = "Please enter your phone number.";
        $valid = false;
    }

    // If all inputs are valid, store them in the session and proceed
    if ($valid) {
        $_SESSION['full_name'] = $full_name;
        $_SESSION['email'] = $_POST['email']; // Store raw email to preserve input in case of invalid format
        $_SESSION['phone'] = $phone;

        // Redirect to the next step
        header("Location: edu_Info.php");
        exit();
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
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
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
            background: #d9534f;
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
            text-align: left;
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
        <input type="text" id="full_name" name="full_name" value="<?php echo $_SESSION['full_name'] ?? ''; ?>">
        <?php if (!empty($full_name_error)) echo "<p class='error'>$full_name_error</p>"; ?>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" value="<?php echo $_SESSION['email'] ?? ''; ?>">
        <?php if (!empty($email_error)) echo "<p class='error'>$email_error</p>"; ?>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $_SESSION['phone'] ?? ''; ?>">
        <?php if (!empty($phone_error)) echo "<p class='error'>$phone_error</p>"; ?>

        <input type="submit" value="Next">
        <button onclick="window.location.href='login.html'; return false;">Logout</button>
    </form>
</div>

</body>
</html>
