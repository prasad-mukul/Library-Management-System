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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Library Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #198754 40%, #0d6efd 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .register-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            padding: 30px;
            width: 400px;
            animation: fadeIn 0.5s ease-in-out;
        }

        .register-card h3 {
            font-weight: bold;
            color: #198754;
        }

        .register-card .form-control {
            border-radius: 8px;
        }

        .register-card button {
            border-radius: 8px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .register-card a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }

        .register-card a:hover {
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
    <div class="register-card">
        <div class="brand-header">
            <!-- <img src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png" alt="Library Logo"> -->
            <h3>Create Account</h3>
            <p class="text-muted small">Join our Library Management System</p>
        </div>

        <?php if ($message): ?>
            <div class="alert <?php echo (strpos($message, '✅') !== false) ? 'alert-success' : 'alert-danger'; ?> text-center py-2">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">👤 Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">📧 Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">🔒 Password</label>
                <input type="password" name="password" class="form-control" placeholder="Create a password" required>
            </div>
            <button type="submit" name="register" class="btn btn-success w-100 py-2">Register</button>

            <p class="mt-3 text-center mb-0">
                Already have an account? <a href="index.php">Login</a>
            </p>
        </form>
    </div>

    <footer>
        © <?php echo date("Y"); ?> Library Management System | Designed by HERO
    </footer>
</body>
</html>
