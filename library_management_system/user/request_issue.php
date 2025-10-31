<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit();
}

include('../includes/db.php');

$book_id = $_GET['id'] ?? 0;

// Check if book exists and available
$book_result = $conn->query("SELECT * FROM books WHERE id=$book_id");
if ($book_result->num_rows == 0) {
    die("Book not found!");
}

$book = $book_result->fetch_assoc();

if ($book['quantity'] <= 0) {
    die("Sorry, this book is currently not available.");
}

// Insert into issued_books
$user_id = $_SESSION['user_id'];
$conn->query("INSERT INTO issued_books (book_id, user_id) VALUES ($book_id, $user_id)");

// Decrease quantity
$conn->query("UPDATE books SET quantity = quantity - 1 WHERE id=$book_id");

echo "<script>alert('Book issued successfully!'); window.location.href='search_books.php';</script>";
