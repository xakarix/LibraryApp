<?php
include('db_connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectToDatabase();

    $title = $_POST["title"];
    $author = $_POST["author"];
    $description = $_POST["description"];
    $purchaseDate = $_POST["purchase-date"];
    $ownerId = $_SESSION['user_id'];  

    $sql = "INSERT INTO book (title, author, description, purchaseDate, owner_id) VALUES ('$title', '$author', '$description', '$purchaseDate', '$ownerId')";

    if ($conn->query($sql) === TRUE) {
        header("Location: main.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="main-container">
      
        <div class="content-container">
            <h2>BOOK DESCRIPTION</h2>
            <form action="manage.php" method="post">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>

                <label for="title">Author:</label>
                <input type="text" id="author" name="author" required>
                
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="3" required></textarea>
                
                <label for="purchase-date">Purchase Date:</label>
                <input type="date" id="purchase-date" name="purchase-date" required>

                <button type="submit" class="empty-button">ADD</button>
            </form>
        </div>
    </div>
</body>
</html>
