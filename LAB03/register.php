<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $username = htmlspecialchars($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    // Check if all fields are provided
    if ($username && $email && $password) {
        // Check if the users.json file exists
        $file = 'users.json';
        if (file_exists($file)) {
            // Read the existing users
            $users = json_decode(file_get_contents($file), true);

            // Check for existing username
            foreach ($users as $user) {
                if ($user['username'] === $username) {
                    echo "Username already exists. Please choose a different username.";
                    exit();
                }
            }
        }

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
    } else {
        echo "Please fill all the fields correctly.";
    }
}
?>
