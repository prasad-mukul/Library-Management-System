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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Issued Books | Library System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 900px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .card-header {
            background: linear-gradient(90deg, #007bff, #00c6ff);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .table thead {
            background-color: #007bff;
            color: white;
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
            border-radius: 25px;
            transition: 0.3s;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
        .no-data {
            text-align: center;
            color: #888;
            padding: 30px 0;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center py-3">
            <h4 class="mb-0"><i class="bi bi-journal-bookmark"></i> My Issued Books</h4>
        </div>
        <div class="card-body">
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Issue Date</th>
                                <th>Return Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                                    <td><?php echo date("d M Y", strtotime($row['issue_date'])); ?></td>
                                    <td>
                                        <?php 
                                            $return_date = date("d M Y", strtotime($row['issue_date']. ' + 7 days'));
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
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="no-data">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076508.png" width="100" alt="No data">
                    <p class="mt-3">You haven’t issued any books yet.</p>
                </div>
            <?php endif; ?>

            <div class="text-center mt-4">
                <a href="user_dashboard.php" class="btn btn-back px-4">← Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</body>
</html>
