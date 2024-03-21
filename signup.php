<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectToDatabase();

    $username = $_POST["username"];
    $password = $_POST["password"];
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $checkExistingUser = "SELECT * FROM user WHERE username = '$username'";
    $result = $conn->query($checkExistingUser);
    $checkExistingPassword = "SELECT * FROM user WHERE password = '$password'";
    $resultPassword = $conn->query($checkExistingPassword);

    if ($result->num_rows > 0 || $resultPassword->num_rows > 0 ) {
        echo "Username already taken. Please choose a different username.";
    } else {
        $sql = "INSERT INTO user (role_id, username, password, first_name, last_name) VALUES (2, '$username', '$hashedPassword', '$firstName', '$lastName')";

        if ($conn->query($sql) === TRUE) {
            header("Location: main.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <a href="home.php">Home</a>
        <a href="signin.php">Sign in</a>
        <a href="signup.php">Sign up</a>
    </nav>

    <div class="login-container">
        <div class="login-box">
            <h2>REGISTER</h2>
            <form action="signup.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="first-name">First Name:</label>
                <input type="text" id="first-name" name="first_name" required>

                <label for="last-name">Last Name:</label>
                <input type="text" id="last-name" name="last_name" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <!-- <label for="confirm-password">Confirm Password:</label> -->
                <!-- <input type="password" id="confirm-password" name="confirm-password" required> -->
                
                <div class="buttons-container">
                    <a href="signin.php" class="fill-button">Sign in</a>
                    <button type="submit" class="empty-button">Sign up</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
