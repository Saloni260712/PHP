<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Initialize error messages
$degree_error = $field_of_study_error = $institution_error = $graduation_year_error = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $degree = htmlspecialchars($_POST['degree']);
    $field_of_study = htmlspecialchars($_POST['field_of_study']);
    $institution = htmlspecialchars($_POST['institution']);
    $graduation_year = htmlspecialchars($_POST['graduation_year']);

    // Validate inputs
    $valid = true;

    if (empty($degree)) {
        $degree_error = "Please enter your highest degree.";
        $valid = false;
    }

    if (empty($field_of_study)) {
        $field_of_study_error = "Please enter your field of study.";
        $valid = false;
    }

    if (empty($institution)) {
        $institution_error = "Please enter the name of your institution.";
        $valid = false;
    }

    if (empty($graduation_year)) {
        $graduation_year_error = "Please enter your graduation year.";
        $valid = false;
    } elseif (!is_numeric($graduation_year)) {
        $graduation_year_error = "Please enter a valid year.";
        $valid = false;
    }

    // If all inputs are valid, store them in the session and proceed
    if ($valid) {
        $_SESSION['degree'] = $degree;
        $_SESSION['field_of_study'] = $field_of_study;
        $_SESSION['institution'] = $institution;
        $_SESSION['graduation_year'] = $graduation_year;

        // Redirect to the next step
        header("Location: work_Info.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 2: Educational Background</title>
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
            width: 66%;
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
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Ensures padding doesn't increase width */
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
    <h2>Step 2: Educational Background</h2>

    <!-- Progress bar -->
    <div class="progress">
        <div class="progress-bar">Step 2 of 3</div>
    </div>

    <form action="edu_Info.php" method="POST">
        <label for="degree">Highest Degree Obtained:</label>
        <input type="text" id="degree" name="degree" value="<?php echo $_SESSION['degree'] ?? ''; ?>">
        <?php if (!empty($degree_error)) echo "<p class='error'>$degree_error</p>"; ?>

        <label for="field_of_study">Field of Study:</label>
        <input type="text" id="field_of_study" name="field_of_study" value="<?php echo $_SESSION['field_of_study'] ?? ''; ?>">
        <?php if (!empty($field_of_study_error)) echo "<p class='error'>$field_of_study_error</p>"; ?>

        <label for="institution">Name of Institution:</label>
        <input type="text" id="institution" name="institution" value="<?php echo $_SESSION['institution'] ?? ''; ?>">
        <?php if (!empty($institution_error)) echo "<p class='error'>$institution_error</p>"; ?>

        <label for="graduation_year">Year of Graduation:</label>
        <input type="text" id="graduation_year" name="graduation_year" value="<?php echo $_SESSION['graduation_year'] ?? ''; ?>">
        <?php if (!empty($graduation_year_error)) echo "<p class='error'>$graduation_year_error</p>"; ?>

        <input type="submit" value="Next">
        <button onclick="window.location.href='personal_Info.php'; return false;">Previous</button>
        <button onclick="window.location.href='login.html'; return false;">Logout</button>
    </form>
</div>

</body>
</html>
