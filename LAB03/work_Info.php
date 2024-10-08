<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Initialize error messages
$job_title_error = $company_name_error = $years_of_experience_error = $key_responsibilities_error = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $job_title = htmlspecialchars($_POST['job_title']);
    $company_name = htmlspecialchars($_POST['company_name']);
    $years_of_experience = htmlspecialchars($_POST['years_of_experience']);
    $key_responsibilities = htmlspecialchars($_POST['key_responsibilities']);

    // Validate inputs
    $valid = true;

    if (empty($job_title)) {
        $job_title_error = "Please enter your previous job title.";
        $valid = false;
    }

    if (empty($company_name)) {
        $company_name_error = "Please enter your company name.";
        $valid = false;
    }

    if (empty($years_of_experience)) {
        $years_of_experience_error = "Please enter your years of experience.";
        $valid = false;
    } elseif (!is_numeric($years_of_experience) || $years_of_experience <= 0) {
        $years_of_experience_error = "Please enter a valid positive number for years of experience.";
        $valid = false;
    }

    if (empty($key_responsibilities)) {
        $key_responsibilities_error = "Please enter your key responsibilities.";
        $valid = false;
    }

    // If all inputs are valid, store them in the session and proceed
    if ($valid) {
        $_SESSION['job_title'] = $job_title;
        $_SESSION['company_name'] = $company_name;
        $_SESSION['years_of_experience'] = $years_of_experience;
        $_SESSION['key_responsibilities'] = $key_responsibilities;

        // Redirect to the review page
        header("Location: application_review.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 3: Work Experience</title>
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
            width: 100%;
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
        input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
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
    </style>
</head>
<body>

<div class="container">
    <h2>Step 3: Work Experience</h2>

    <!-- Progress bar -->
    <div class="progress">
        <div class="progress-bar">Step 3 of 3</div>
    </div>

    <form action="work_Info.php" method="POST">
        <label for="job_title">Previous Job Title:</label>
        <input type="text" id="job_title" name="job_title" value="<?php echo $_SESSION['job_title'] ?? ''; ?>">
        <?php if (!empty($job_title_error)) echo "<p class='error'>$job_title_error</p>"; ?>

        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" value="<?php echo $_SESSION['company_name'] ?? ''; ?>">
        <?php if (!empty($company_name_error)) echo "<p class='error'>$company_name_error</p>"; ?>

        <label for="years_of_experience">Years of Experience:</label>
        <input type="number" id="years_of_experience" name="years_of_experience" value="<?php echo $_SESSION['years_of_experience'] ?? ''; ?>">
        <?php if (!empty($years_of_experience_error)) echo "<p class='error'>$years_of_experience_error</p>"; ?>

        <label for="key_responsibilities">Key Responsibilities:</label>
        <textarea id="key_responsibilities" name="key_responsibilities" rows="4"><?php echo $_SESSION['key_responsibilities'] ?? ''; ?></textarea>
        <?php if (!empty($key_responsibilities_error)) echo "<p class='error'>$key_responsibilities_error</p>"; ?>

        <input type="submit" value="Next">
        <button onclick="window.location.href='edu_Info.php'; return false;">Previous</button>
        <button onclick="window.location.href='login.html'; return false;">Logout</button>
    </form>
</div>

</body>
</html>
