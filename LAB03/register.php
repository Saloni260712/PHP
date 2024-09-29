<?php
$errors = []; // Initialize an array to hold error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $username = htmlspecialchars(trim($_POST['username']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password']);

    // Check if all fields are provided
    if (empty($username)) {
        $errors['username'] = "Please enter a valid username.";
    }
    if (empty($email) || !$email) {
        $errors['email'] = "Please enter a valid email address.";
    }
    if (empty($password)) {
        $errors['password'] = "Please enter a password.";
    }

    // If there are no errors, process the registration
    if (empty($errors)) {
        // Check if the users.json file exists
        $file = 'users.json';
        if (file_exists($file)) {
            // Read the existing users
            $users = json_decode(file_get_contents($file), true);

            // Check for existing username
            foreach ($users as $user) {
                if ($user['username'] === $username) {
                    $errors['username'] = "Username already exists. Please choose a different username.";
                    break;
                }
            }
        }

        // If there are no existing usernames, proceed
        if (empty($errors)) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the user data
            $user_data = [
                'username' => $username,
                'email' => $email,
                'password' => $hashed_password,
            ];

            // If the users.json file doesn't exist, create it
            if (!file_exists($file)) {
                file_put_contents($file, json_encode([])); // Create an empty JSON file if it doesn't exist
            }

            // Append the new user
            $users[] = $user_data;

            // Save the updated users list
            file_put_contents($file, json_encode($users));

            echo "Registration successful! You can now <a href='login.html'>login</a>.";
            exit();
        }
    }
}
?>