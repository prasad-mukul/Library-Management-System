<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard | Library Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: linear-gradient(90deg, #007bff, #0056b3);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .dashboard-container {
            margin-top: 70px;
        }

        .welcome-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.08);
            text-align: center;
        }

        .dashboard-title {
            font-weight: 600;
            color: #333;
        }

        .card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }

        .card-title {
            font-size: 1.2rem;
            color: #0d6efd;
            font-weight: 600;
        }

        .card-text {
            color: #555;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }


        footer {
            position: relative;
            bottom: 0;
            width: 100%;
            background: #0d6efd;
            color: white;
            text-align: center;
            padding: 15px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            font-size: 0.9rem;
            margin-top: auto;
        }

    /* Ensure body takes full height for sticky footer effect */
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .dashboard-container {
            flex: 1;
        }
        /* footer {
            position: relative;
            bottom: 0;
            background: #0d6efd;
            color: white;
            text-align: center;
            padding: 15px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            font-size: 0.9rem;
        } */

        .logout-btn {
            background: #dc3545;
            border: none;
        }

        .logout-btn:hover {
            background: #bb2d3b;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">📚 Library System</a>
    <div class="d-flex">
        <a href="../logout.php" class="btn logout-btn text-white px-3">Logout</a>
    </div>
  </div>
</nav>

<!-- Dashboard Content -->
<div class="container dashboard-container">
    <div class="welcome-card mb-5">
        <h3 class="dashboard-title">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h3>
        <p class="text-muted">Manage your library activities from here.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm text-center py-4">
                <div class="card-body">
                    <h5 class="card-title">🔍 Search Books</h5>
                    <p class="card-text">Find books by title, author, or category.</p>
                    <a href="search_books.php" class="btn btn-primary">Search</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm text-center py-4">
                <div class="card-body">
                    <h5 class="card-title">📖 Issued Books</h5>
                    <p class="card-text">Check which books are currently issued to you.</p>
                    <a href="issued_books.php" class="btn btn-primary">View</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm text-center py-4">
                <div class="card-body">
                    <h5 class="card-title">⚙️ Edit Profile</h5>
                    <p class="card-text">Update your personal details or password.</p>
                    <a href="profile.php" class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    © <?php echo date("Y"); ?> Library Management System | Designed by HERO
</footer>

</body>
</html>
