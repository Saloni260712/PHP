<?php
session_start(); // Start the session

// Initialize error messages
$username_error = '';
$password_error = '';
$error_message = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Check if the users.json file exists
    $file = 'users.json';
    if (file_exists($file)) {
        // Read the JSON file and decode the data
        $users = json_decode(file_get_contents($file), true);
        $user_found = false;

        // Loop through users to find a match
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                $user_found = true; // User found
                // Verify the password
                if (password_verify($password, $user['password'])) {
                    // Start a session for the user
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $user['email'];

                    // Handle "Remember Me" functionality
                    if (isset($_POST['remember'])) {
                        // Set a cookie that expires in 7 days
                        setcookie('username', $username, time() + (7 * 24 * 60 * 60), "/"); // 7 days
                    } else {
                        // Clear the cookie if "Remember Me" is not selected
                        if (isset($_COOKIE['username'])) {
                            setcookie('username', '', time() - 3600, "/"); // Expire the cookie
                        }
                    }

                    // Redirect to the job application form
                    header("Location: personal_Info.php");
                    exit();
                } else {
                    $password_error = "Incorrect password.";
                }
            }
        }
        
        // If username is not found
        if (!$user_found) {
            $username_error = "Username not found.";
        }
    } else {
        $error_message = "No users registered yet.";
    }
}
?>
