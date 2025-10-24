<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../includes/db.php');

// Get total books
$total_books_result = $conn->query("SELECT COUNT(*) AS total FROM books");
$total_books_row = $total_books_result->fetch_assoc();
$total_books = $total_books_row['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard | Library Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand">Admin Panel</span>
    <div class="d-flex">
        <a href="../logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <h3>Welcome, <?php echo $_SESSION['username']; ?> 👋</h3>
    <hr>
    <div class="row g-4">

        <!-- Total Books -->
        <div class="col-md-3">
            <div class="card text-center shadow-sm bg-info text-white h-100 d-flex flex-column">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title">📚 Total Books</h5>
                    <p class="card-text fs-4"><?php echo $total_books; ?></p>
                </div>
            </div>
        </div>

        <!-- Add Books -->
        <div class="col-md-3">
            <div class="card text-center shadow-sm h-100 d-flex flex-column">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title">➕ Add Books</h5>
                    <p class="card-text">Add new books to the library database.</p>
                    <a href="add_book.php" class="btn btn-outline-dark btn-sm mt-auto">Add</a>
                </div>
            </div>
        </div>

        <!-- Manage Books -->
        <div class="col-md-3">
            <div class="card text-center shadow-sm h-100 d-flex flex-column">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title">📝 Manage Books</h5>
                    <p class="card-text">View, edit, or delete library books.</p>
                    <a href="manage_books.php" class="btn btn-outline-dark btn-sm mt-auto">Manage</a>
                </div>
            </div>
        </div>

        <!-- Manage Users -->
        <div class="col-md-3">
            <div class="card text-center shadow-sm h-100 d-flex flex-column">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title">👥 Manage Users</h5>
                    <p class="card-text">View or delete registered users.</p>
                    <a href="manage_users.php" class="btn btn-outline-dark btn-sm mt-auto">Manage</a>
                </div>
            </div>
        </div>

        <!-- Issued Books -->
        <div class="col-md-3">
            <div class="card text-center shadow-sm h-100 d-flex flex-column">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title">📦 Issued Books</h5>
                    <p class="card-text">Track all issued or returned books.</p>
                    <a href="issued_books.php" class="btn btn-outline-dark btn-sm mt-auto">View</a>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
