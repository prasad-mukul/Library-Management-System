<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit();
}

include('../includes/db.php');

$user_id = $_SESSION['user_id'];

// Fetch books issued to this user
$sql = "SELECT ib.id, b.title, ib.issue_date, ib.status
        FROM issued_books ib
        JOIN books b ON ib.book_id = b.id
        WHERE ib.user_id = $user_id
        ORDER BY ib.issue_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Issued Books | Library System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3>My Issued Books</h3>
    <hr>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Issue Date</th>
                <th>Return Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo date("d M Y, H:i", strtotime($row['issue_date'])); ?></td>
                    <td>
                        <?php 
                        $return_date = date("d M Y, H:i", strtotime($row['issue_date']. ' + 7 days'));
                        echo $return_date;
                        ?>
                    </td>
                    <td>
                        <?php if ($row['status'] == 'issued'): ?>
                            <span class="badge bg-success">Issued</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Returned</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">You have not issued any books yet.</td>
            </tr>
        <?php endif; ?>
    </tbody>

            
    </table>

    <a href="user_dashboard.php" class="btn btn-secondary">Back</a>
</div>

</body>
</html>
