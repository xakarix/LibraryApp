<?php
require_once('fpdf.php'); 
require_once('db_connection.php');

$book_id = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;

if ($book_id <= 0) {
    header("Location: main.php");
    exit();
}

$conn = connectToDatabase();
$sql = "SELECT title, author, description, purchaseDate FROM book WHERE book_id = $book_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Utwórz nowy obiekt FPDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Dodaj dane książki do pliku PDF
    $pdf->Cell(40, 10, 'Title: ' . $row['title']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Author: ' . $row['author']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Description: ' . $row['description']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Purchase Date: ' . $row['purchaseDate']);

    // Wysyłanie pliku PDF do przeglądarki
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="book_' . $book_id . '.pdf"');
    echo $pdf->Output('S');
    
    exit();
} else {
    echo "Book not found.";
}

$conn->close();
?>
