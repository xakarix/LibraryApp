<?php
include('db_connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectToDatabase();
    
    $username = $_POST["username"];
    $password = $_POST["password"];

    $getPasswordQuery = "SELECT id, role_id, password FROM user WHERE username = '$username'";
    $result = $conn->query($getPasswordQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPasswordFromDatabase = $row["password"];

        if (password_verify($password, $hashedPasswordFromDatabase)) {
            $_SESSION['user_id'] = $row["id"];
            $_SESSION['role_id'] = $row["role_id"];
            
            header("Location: main.php");
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }

    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            <h2>LOGIN</h2>
            <form action="signin.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <div class="buttons-container">
                    <a href="signup.php" class="fill-button">Sign up</a>
                    <button type="submit" class="empty-button">Sign in</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
