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
    // Uncomment the line below to enable email sending in a real environment
    // mail($to, $subject, $message); 

    // Clear session data
    session_destroy();

    // Clear cookies if any set for "Remember Me"
    if (isset($_COOKIE['remember_me'])) {
        setcookie('remember_me', '', time() - 3600, '/'); // Clear the cookie
    }

    echo "<h2>Application submitted successfully!</h2>";
    echo "<p>A confirmation email has been sent to $to.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Your Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        h3 {
            color: #555;
        }
        p {
            margin: 5px 0;
            line-height: 1.5;
            color: #333;
        }
        input[type="submit"], .edit-button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background: #5cb85c;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover, .edit-button:hover {
            background: #4cae4c;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin: 10px 0;
        }
        a {
            text-decoration: none;
            color: #5bc0de;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .logout-button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background: #d9534f;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .logout-button:hover {
            background: #c9302c;
        }
    </style>
</head>
<body>

<div class="container">
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
    <button class="edit-button" onclick="window.location.href='personal_Info.php';">Edit Personal Information</button>
    <button class="edit-button" onclick="window.location.href='edu_Info.php';">Edit Educational Background</button>
    <button class="edit-button" onclick="window.location.href='work_Info.php';">Edit Work Experience</button>

    <h3>Logout</h3>
    <form action="logout.php" method="POST">
        <button type="submit" class="logout-button">Logout</button>
    </form>
</div>

</body>
</html>
