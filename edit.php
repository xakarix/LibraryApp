<?php
include('db_connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

if (!isset($_GET['book_id'])) {
    header("Location: main.php");
    exit();
}

$bookId = $_GET['book_id'];

$conn = connectToDatabase();
$ownerId = $_SESSION['user_id'];
$sql = "SELECT * FROM book WHERE owner_id = ? AND book_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $ownerId, $bookId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $bookData = $result->fetch_assoc();
} else {
    header("Location: main.php");
    exit();
}

// Obsługa formularza edycji
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newTitle = $_POST["new_title"];
    $newAuthor = $_POST["new_author"];
    $newDescription = $_POST["new_description"];
    $newPurchaseDate = $_POST["new_purchase_date"];

    // Aktualizacja danych w bazie danych
    $updateSql = "UPDATE book SET title = ?, author = ?, 
                  description = ?, purchaseDate = ? 
                  WHERE book_id = ? AND owner_id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssssii", $newTitle, $newAuthor, $newDescription, $newPurchaseDate, $bookId, $ownerId);

    if ($updateStmt->execute()) {
        header("Location: main.php");
        exit();
    } else {
        error_log("Error updating record: " . $conn->error);
        header("Location: error.php"); 
        exit();
    }
}

$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="main-container">
        <div class="content-container">
            <h2>Edit Book</h2>
            <form action="edit.php?book_id=<?php echo $bookId; ?>" method="post">
                <label for="new_title">Title:</label>
                <input type="text" id="new_title" name="new_title" value="<?php echo $bookData['title']; ?>" required>

                <label for="new_author">Author:</label>
                <input type="text" id="new_author" name="new_author" value="<?php echo $bookData['author']; ?>" required>
                
                <label for="new_description">Description:</label>
                <textarea id="new_description" name="new_description" rows="3" required><?php echo $bookData['description']; ?></textarea>
                
                <label for="new_purchase_date">Purchase Date:</label>
                <input type="date" id="new_purchase_date" name="new_purchase_date" value="<?php echo $bookData['purchaseDate']; ?>" required>

                <button type="submit" class="empty-button">Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>
