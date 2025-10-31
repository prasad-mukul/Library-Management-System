<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../includes/db.php');

// Delete book
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM books WHERE id=$id");
    header("Location: manage_books.php");
    exit();
}

$result = $conn->query("SELECT * FROM books ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Books | Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
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

        /* Main layout */
        .main-content {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex-grow: 1;
            padding: 40px;
        }

        /* Table styling */
        table th {
            background-color: #0d6efd;
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: #e9f2ff;
        }

        /* Footer */
        .content-footer {
            background-color: #0d6efd;
            color: white;
            text-align: center;
            padding: 12px 0;
            position: fixed;
            bottom: 0;
            left: 250px;
            width: calc(100% - 250px);
            z-index: 1000;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center mb-4">📘 Admin Panel</h4>
    <a href="admin_dashboard.php">🏠 Dashboard</a>
    <a href="add_book.php">➕ Add Books</a>
    <a href="manage_books.php" class="active">📝 Manage Books</a>
    <a href="issued_books.php">📦 Issued Books</a>
    <a href="manage_users.php">👥 Manage Users</a>
    <a href="../logout.php" class="text-danger">🚪 Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-primary mb-0">📚 Manage Books</h3>
            <a href="add_book.php" class="btn btn-warning">
                <i class="bi bi-plus-circle"></i> Add New Book
            </a>
        </div>

        <div class="table-responsive shadow-sm bg-white rounded p-3">
            <table class="table table-hover table-striped align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $count = 1; while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?php echo $count++; ?></strong></td>
                                <td class="text-start">
                                    <i class="bi bi-book"></i>
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['author']); ?></td>
                                <td><?php echo htmlspecialchars($row['category']); ?></td>
                                <td>
                                    <span class="badge rounded-pill bg-secondary px-3 py-2">
                                        <?php echo $row['quantity']; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="edit_book.php?id=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                       <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <a href="manage_books.php?delete=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Are you sure you want to delete this book?')">
                                       <i class="bi bi-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-book-half"></i> No books found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="content-footer">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> Library Management System | Admin Panel</p>
    </footer>
</div>

</body>
</html>
