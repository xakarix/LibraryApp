<?php
include('db_connection.php');
session_start();
$conn=connectToDatabase();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

if (!isset($_GET['book_id'])) {
    header("Location: main.php");
    exit();
}

$bookId = $_GET['book_id'];

$deleteSql = "DELETE FROM book WHERE book_id = '$bookId'";
$conn->query($deleteSql);


header("Location: main.php");
exit();
?>
