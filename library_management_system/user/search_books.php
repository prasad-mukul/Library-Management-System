<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit();
}

include('../includes/db.php');

// Get user input safely
$search = $_GET['search'] ?? '';
$filter = $_GET['filter'] ?? 'all';

// Build SQL query based on filter
switch ($filter) {
    case 'title':
        $sql = "SELECT * FROM books WHERE title LIKE '%$search%'";
        break;
    case 'author':
        $sql = "SELECT * FROM books WHERE author LIKE '%$search%'";
        break;
    case 'category':
        $sql = "SELECT * FROM books WHERE category LIKE '%$search%'";
        break;
    default:
        $sql = "SELECT * FROM books WHERE title LIKE '%$search%' 
                OR author LIKE '%$search%' 
                OR category LIKE '%$search%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Books | Library System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(120deg, #e3f2fd, #f8f9fa);
            font-family: 'Poppins', sans-serif;
        }
        .search-container {
            background: #fff;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        h3 {
            color: #007bff;
            font-weight: 600;
        }
        .form-control, .form-select {
            border-radius: 25px;
            padding: 10px 15px;
        }
        .btn-search {
            background: linear-gradient(90deg, #007bff, #00c6ff);
            color: white;
            border-radius: 25px;
            transition: 0.3s;
            border: none;
        }
        .btn-search:hover {
            opacity: 0.9;
        }
        .btn-back {
            border-radius: 25px;
        }
        table {
            margin-top: 20px;
        }
        thead {
            background: #007bff;
            color: white;
        }
        tbody tr:hover {
            background-color: #f1f9ff;
        }
        .status-available {
            background: #28a745;
            color: white;
            border-radius: 15px;
            padding: 5px 10px;
            font-size: 0.9rem;
        }
        .status-unavailable {
            background: #dc3545;
            color: white;
            border-radius: 15px;
            padding: 5px 10px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="search-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><i class="bi bi-search"></i> Search Books</h3>
            <a href="user_dashboard.php" class="btn btn-secondary btn-back"><i class="bi bi-arrow-left"></i> Back</a>
        </div>

        <!-- Search Form -->
        <form method="GET" class="row g-3 mb-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Enter keyword..." 
                       value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="col-md-3">
                <select name="filter" class="form-select">
                    <option value="all" <?php if($filter=='all') echo 'selected'; ?>>All</option>
                    <option value="title" <?php if($filter=='title') echo 'selected'; ?>>Title</option>
                    <option value="author" <?php if($filter=='author') echo 'selected'; ?>>Author</option>
                    <option value="category" <?php if($filter=='category') echo 'selected'; ?>>Category</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-search w-100" type="submit"><i class="bi bi-search"></i> Search</button>
            </div>
        </form>

        <!-- Results Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>📘 Title</th>
                        <th>✍️ Author</th>
                        <th>🏷️ Category</th>
                        <th>📦 Availability</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><?php echo htmlspecialchars($row['author']); ?></td>
                                <td><?php echo htmlspecialchars($row['category']); ?></td>
                                <td>
                                    <?php if ($row['quantity'] > 0): ?>
                                        <a href="request_issue.php?id=<?php echo $row['id']; ?>" 
                                           class="status-available text-decoration-none">Available</a>
                                    <?php else: ?>
                                        <span class="status-unavailable">Unavailable</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">
                                <i class="bi bi-emoji-frown"></i> No books found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
