<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard | Library Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <span class="navbar-brand">Library System</span>
    <div class="d-flex">
        <a href="../logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <h3>Welcome, <?php echo $_SESSION['username']; ?> 👋</h3>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📚 Search Books</h5>
                    <p class="card-text">Find available books in the library.</p>
                    <a href="search_books.php" class="btn btn-outline-primary btn-sm">Search</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📖 Issued Books</h5>
                    <p class="card-text">View your currently issued books.</p>
                    <a href="issued_books.php" class="btn btn-outline-primary btn-sm">View</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">⚙️ Edit Profile</h5>
                    <p class="card-text">Change your username or password.</p>
                    <a href="profile.php" class="btn btn-outline-primary btn-sm">Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
