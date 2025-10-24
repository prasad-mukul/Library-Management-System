<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../includes/db.php');
$message = "";

// Get book ID
$id = $_GET['id'] ?? 0;

// Fetch existing book data
$result = $conn->query("SELECT * FROM books WHERE id=$id");
if ($result->num_rows == 0) {
    die("Book not found!");
}
$book = $result->fetch_assoc();

// Update book
if (isset($_POST['update_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];

    $sql = "UPDATE books 
            SET title='$title', author='$author', category='$category', quantity='$quantity' 
            WHERE id=$id";

    if ($conn->query($sql)) {
        $message = "✅ Book updated successfully!";
        $book = ['title'=>$title,'author'=>$author,'category'=>$category,'quantity'=>$quantity];
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Book | Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3>Edit Book</h3>
    <hr>
    <?php if ($message) echo "<div class='alert alert-info'>$message</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo $book['title']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Author</label>
            <input type="text" name="author" class="form-control" value="<?php echo $book['author']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control" value="<?php echo $book['category']; ?>">
        </div>
        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" value="<?php echo $book['quantity']; ?>" required min="1">
        </div>
        <button type="submit" name="update_book" class="btn btn-success">Update Book</button>
        <a href="manage_books.php" class="btn btn-secondary">Back</a>
    </form>
</div>

</body>
</html>
