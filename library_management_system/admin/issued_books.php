<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../includes/db.php');

// Mark as returned
if (isset($_GET['return_id'])) {
    $id = $_GET['return_id'];

    // Update issued_books
    $conn->query("UPDATE issued_books SET status='returned', return_date=NOW() WHERE id=$id");

    // Increment book quantity
    $book_result = $conn->query("SELECT book_id FROM issued_books WHERE id=$id");
    $book_id = $book_result->fetch_assoc()['book_id'];
    $conn->query("UPDATE books SET quantity = quantity + 1 WHERE id=$book_id");

    header("Location: issued_books.php");
    exit();
}

// Fetch all issued books
$sql = "SELECT ib.id, b.title, u.username, ib.issue_date, ib.status
        FROM issued_books ib
        JOIN books b ON ib.book_id = b.id
        JOIN users u ON ib.user_id = u.id
        ORDER BY ib.issue_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Issued Books | Admin Panel</title>
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
        table th {
            background-color: #0d6efd;
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: #e9f2ff;
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

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center mb-4">📘 Admin Panel</h4>
    <a href="admin_dashboard.php">🏠 Dashboard</a>
    <a href="add_book.php">➕ Add Books</a>
    <a href="manage_books.php">📝 Manage Books</a>
    <a href="issued_books.php" class="active">📦 Issued Books</a>
    <a href="manage_users.php">👥 Manage Users</a>
    <a href="../logout.php" class="text-danger">🚪 Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-primary mb-0">📦 Issued Books</h3>
        </div>

        <div class="table-responsive shadow-sm bg-white rounded p-3">
            <table class="table table-hover table-striped align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Book Title</th>
                        <th>Issued To</th>
                        <th>Issue Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
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
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo date("d M Y, H:i", strtotime($row['issue_date'])); ?></td>
                                <td><?php echo date("d M Y, H:i", strtotime($row['issue_date'] . ' + 7 days')); ?></td>
                                <td>
                                    <?php if ($row['status'] == 'issued'): ?>
                                        <span class="badge rounded-pill bg-success px-3 py-2">Issued</span>
                                    <?php else: ?>
                                        <span class="badge rounded-pill bg-secondary px-3 py-2">Returned</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 'issued'): ?>
                                        <a href="issued_books.php?return_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning" onclick="return confirm('Mark this book as returned?')">
                                            <i class="bi bi-arrow-return-left"></i> Return
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox"></i> No issued books found.
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
