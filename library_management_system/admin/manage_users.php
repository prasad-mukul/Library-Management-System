<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../includes/db.php');

// Delete user (only if clicked)
if (isset($_GET['delete_id'])) {
    $user_id = $_GET['delete_id'];

    // First delete all issued_books for this user
    $conn->query("DELETE FROM issued_books WHERE user_id=$user_id");

    // Then delete the user
    $conn->query("DELETE FROM users WHERE id=$user_id");

    header("Location: manage_users.php");
    exit();
}

// Fetch all users
$sql = "SELECT * FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users | Admin Panel</title>
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

        /* Main Content Layout */
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

        /* Table Design */
        table th {
            background-color: #0d6efd;
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: #e9f2ff;
        }

        /* Footer Styling */
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
    <a href="manage_books.php">📝 Manage Books</a>
    <a href="issued_books.php">📦 Issued Books</a>
    <a href="manage_users.php" class="active">👥 Manage Users</a>
    <a href="../logout.php" class="text-danger">🚪 Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-primary mb-0">👥 Manage Users</h3>
        </div>

        <div class="table-responsive shadow-sm bg-white rounded p-3">
            <table class="table table-hover table-striped align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registered At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $count = 1; while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?php echo $count++; ?></strong></td>
                                <td class="text-start">
                                    <i class="bi bi-person-circle"></i>
                                    <?php echo htmlspecialchars($row['username']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td>
                                    <span class="badge rounded-pill bg-<?php echo ($row['role'] == 'admin') ? 'danger' : 'primary'; ?> px-3 py-2">
                                        <?php echo ucfirst($row['role']); ?>
                                    </span>
                                </td>
                                <td><?php echo date("d M Y, H:i", strtotime($row['created_at'])); ?></td>
                                <td>
                                    <?php if ($row['role'] !== 'admin'): ?>
                                        <a href="manage_users.php?delete_id=<?php echo $row['id']; ?>"
                                           class="btn btn-sm btn-outline-info"
                                           onclick="return confirm('Are you sure you want to delete this user?')">
                                           <i class="bi bi-trash"></i> Delete
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-person-x"></i> No users found.
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
