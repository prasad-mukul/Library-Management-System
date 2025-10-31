<?php
session_start();
include('includes/db.php');

$message = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        if ($row['role'] === 'admin') {
            header("Location: admin/admin_dashboard.php");
        } else {
            header("Location: user/user_dashboard.php");
        }
        exit();
    } else {
        $message = "❌ Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Library Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd 40%, #3b5998 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            background: #fff;
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            padding: 30px;
            width: 380px;
            animation: fadeIn 0.5s ease-in-out;
        }

        .login-card h3 {
            font-weight: bold;
            color: #0d6efd;
        }

        .login-card .form-control {
            border-radius: 8px;
        }

        .login-card button {
            border-radius: 8px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .login-card a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }

        .login-card a:hover {
            text-decoration: underline;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 15px;
        }

        .brand-header img {
            width: 70px;
            margin-bottom: 10px;
        }

        footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
            color: white;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="brand-header">
            <!-- <img src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png" alt="Library Logo"> -->
            <h3>Library Login</h3>
            <p class="text-muted small">Welcome to Library Management System</p>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-danger text-center py-2"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">📧 Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">🔒 Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100 py-2">Login</button>

            <p class="mt-3 text-center mb-0">
                Don’t have an account? <a href="register.php">Register</a>
            </p>
        </form>
    </div>

    <footer>
        © <?php echo date("Y"); ?> Library Management System | Designed by HERO
    </footer>
</body>
</html>
