<?php
include('includes/db.php');
$message = "";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user already exists
    $check = "SELECT * FROM users WHERE email='$email' OR username='$username'";
    $res = $conn->query($check);

    if ($res->num_rows > 0) {
        $message = "⚠️ Username or Email already exists!";
    } else {
        $sql = "INSERT INTO users (username, email, password, role) 
                VALUES ('$username', '$email', '$password', 'user')";
        if ($conn->query($sql)) {
            $message = "✅ Registration successful! You can now login.";
        } else {
            $message = "❌ Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register | Library Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h3 class="text-center mb-3">Register</h3>
                    <?php if ($message) echo "<div class='alert alert-info'>$message</div>"; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="register" class="btn btn-success w-100">Register</button>
                        <p class="mt-3 text-center">
                            Already have an account? <a href="index.php">Login</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
