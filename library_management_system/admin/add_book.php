<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../includes/db.php');
$message = "";

if (isset($_POST['add_book'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $quantity = (int) $_POST['quantity'];

    $sql = "INSERT INTO books (title, author, category, quantity) 
            VALUES ('$title', '$author', '$category', '$quantity')";
    if ($conn->query($sql)) {
        $message = "✅ Book added successfully!";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Book | Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            background-color: #212529;
            color: #fff;
            position: fixed;
            width: 250px;
            padding-top: 20px;
        }
        .sidebar a {
            color: #adb5bd;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #343a40;
            color: #fff;
        }

        /* Main Content */
        .content {
            margin-left: 270px;
            padding: 30px;
            flex: 1;
        }

        /* Card */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background: #fff;
            padding: 25px;
        }

        /* Footer */
        .content-footer {
            background-color: #0d6efd;
            color: white;
            text-align: center;
            padding: 12px 0;
            position: fixed;
            bottom: 0;
            left: 250px; /* same as sidebar width */
            width: calc(100% - 250px);
            z-index: 1000;
        }

        /* Heading */
        .content h3 {
            font-weight: 700;
            color: #0d6efd;
        }

        /* Buttons */
        .btn-custom {
            border-radius: 8px;
            font-weight: 500;
        }

    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center mb-4">📘 Admin Panel</h4>
        <a href="admin_dashboard.php">🏠 Dashboard</a>
        <a href="add_book.php" class="active">➕ Add Books</a>
        <a href="manage_books.php">📝 Manage Books</a>
        <a href="issued_books.php">📦 Issued Books</a>
        <a href="manage_users.php">👥 Manage Users</a>
        <a href="../logout.php" class="text-danger">🚪 Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h3 class="text-center mb-4">➕ Add New Book</h3>

        <div class="card mx-auto" style="max-width: 700px;">
            <?php if ($message): ?>
                <div class="alert alert-info text-center fw-semibold"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST" class="mt-3">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Book Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter book title" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Author Name</label>
                        <input type="text" name="author" class="form-control" placeholder="Enter author name" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category</label>
                        <input type="text" name="category" class="form-control" placeholder="e.g. Fiction, Science">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Quantity</label>
                        <input type="number" name="quantity" class="form-control" required min="1" placeholder="Enter quantity">
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" name="add_book" class="btn btn-success px-5 btn-custom">Add Book</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="content-footer">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> Library Management System | Admin Panel</p>
    </footer>

</body>
</html>
