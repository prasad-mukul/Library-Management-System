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

// Get total users
$total_users_result = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='user'");
$total_users_row = $total_users_result->fetch_assoc();
$total_users = $total_users_row['total'];

// Get total issued books
$total_issued_result = $conn->query("SELECT COUNT(*) AS total FROM issued_books WHERE status='Issued'");
$total_issued_row = $total_issued_result->fetch_assoc();
$total_issued = $total_issued_row['total'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard | Library Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
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
        .content {
            margin-left: 260px;
            padding: 30px;
        }
        .card {
            border: none;
            border-radius: 10px;
            transition: 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .content-footer {
            background-color: #0d6efd;
            color: white;
            text-align: center;
            padding: 12px 0;
            position: fixed;
            bottom: 0;
            left: 250px; /* same as sidebar width */
            width: calc(100% - 250px); /* occupy space beside sidebar */
            z-index: 1000;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4 class="text-center mb-4">📘 Admin Panel</h4>
    <a href="dashboard.php" class="active">🏠 Dashboard</a>
    <a href="add_book.php">➕ Add Books</a>
    <a href="manage_books.php">📝 Manage Books</a>
    <a href="issued_books.php">📦 Issued Books</a>
    <a href="manage_users.php">👥 Manage Users</a>
    <a href="../logout.php" class="text-danger">🚪 Logout</a>
</div>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h3>
    </div>

    <div class="row g-4">
        <!-- Total Books -->
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow-sm p-3">
                <div class="card-body">
                    <h5 class="card-title">📚 Total Books</h5>
                    <p class="display-6 fw-bold mb-0"><?php echo $total_books; ?></p>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-md-4">
            <div class="card bg-success text-white shadow-sm p-3">
                <div class="card-body">
                    <h5 class="card-title">👥 Total Users</h5>
                    <p class="display-6 fw-bold mb-0"><?php echo $total_users; ?></p>
                </div>
            </div>
        </div>

        <!-- Issued Books -->
        <div class="col-md-4">
            <div class="card bg-warning text-dark shadow-sm p-3">
                <div class="card-body">
                    <h5 class="card-title">📦 Issued Books</h5>
                    <p class="display-6 fw-bold mb-0"><?php echo $total_issued; ?></p>
                </div>
            </div>
        </div>
    </div>

    <footer class="content-footer">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> Library Management System | Admin Panel</p>
    </footer>
</div>

</body>
</html>
