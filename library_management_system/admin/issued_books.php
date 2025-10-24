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
<html>
<head>
    <title>Issued Books | Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3>Issued Books</h3>
    <hr>

    <table class="table table-bordered">
        <thead>
            <tr>
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
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo date("d M Y, H:i", strtotime($row['issue_date'])); ?></td>
                        <td>
                            <?php echo date("d M Y, H:i", strtotime($row['issue_date'] . ' + 7 days')); ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'issued'): ?>
                                <span class="badge bg-success">Issued</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Returned</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'issued'): ?>
                                <a href="issued_books.php?return_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning" onclick="return confirm('Mark as returned?')">Return</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No issued books found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="admin_dashboard.php" class="btn btn-secondary">Back</a>
</div>

</body>
</html>
