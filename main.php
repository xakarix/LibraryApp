<?php
include('db_connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="main-container">
        <div >
            <a href="manage.php" class="fill-button">ADD</a>
        </div>

        <div class="content-container">
            <?php
            $conn = connectToDatabase();
            $ownerId = $_SESSION['user_id'];
            $role_id = $_SESSION['role_id'];
            

            if ($role_id == 2) {
                $sql = "SELECT book_id, title, author, description, purchaseDate FROM book  WHERE owner_id = '$ownerId'";
            }else {
                $sql = "SELECT book_id, title, author, description, purchaseDate FROM book";
            }
            
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Description</th>
                            <th>Purchase Date</th>
                        </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['title']}</td>
                            <td>{$row['author']}</td>
                            <td>{$row['description']}</td>
                            <td>{$row['purchaseDate']}</td>
                            <td>
                                <a href='edit.php?book_id={$row['book_id']}' class='action-button'>Edit</a>
                                <a href='delete.php?book_id={$row['book_id']}' class='action-button'>Delete</a>
                                <a href='pdf_generator.php?book_id={$row['book_id']}' class='action-button'>PDF</a>
                            </td>
                        </tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No books found.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
